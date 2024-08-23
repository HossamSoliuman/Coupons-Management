<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\OfferUsage;
use App\Services\OtpService;
use App\Models\VerifiedPhone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GetCodeOffer extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function verifyPhone(Request $request)
    {
        $inputCode = $request->code;
        $inputPhone = $request->phone;

        if ($this->otpService->checkIsVerified($inputPhone)) {
            return response()->json([
                'verified' => 1
            ]);
        } else {
            $this->otpService->sendOtp($inputPhone, $inputCode);
            return response()->json([
                'verified' => 0
            ]);
        }
    }

    public function verifyOtp(Request $request)
    {
        $phone = $request->phone;
        $otp = $request->otp;
        $result = $this->otpService->verify($phone, $otp);

        if ($result['success'] === 1) {
            return response()->json([
                'success' => 1,
                'code' =>  $result['code'],
                'phone' => $result['phone']
            ]);
        } else {
            return response()->json(['success' => 0]);
        }
    }

    public function getOffer(Request $request)
    {
        $inputCode = Str::upper($request->code);
        $inputPhone = $request->phone;

        $code = Code::with(['offers', 'shops'])
            ->where(DB::raw('BINARY name'), $inputCode)
            ->whereHas('shops', function ($query) {
                $query->where('shop_id', auth()->user()->shop_id);
            })
            ->first();


        if (!$code) {
            return response()->json(['error' => 'الرمز غير موجود'], 404);
        }

        if (!$code->is_active) {
            return response()->json(['error' => 'الرمز غير مفعل في الوقت الحالي'], 404);
        }

        $usedOffersByPhone = OfferUsage::with('offer.code')
            ->where('phone_number', $inputPhone)
            ->whereHas('offer.code', function ($query) use ($code) {
                $query->where('code_id', $code->id)->where('shop_id', auth()->user()->shop_id);
            })
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->get();

        if (!$usedOffersByPhone->isEmpty()) {
            return response()->json(['error' => 'لقد تم استخدام هذا الكود خلال اقل من يوم'], 404);
        }



        $offers = $code->offers()
            ->where('used_times', '<', DB::raw('max_usage_times'))
            ->get();

        if ($offers->isEmpty()) {
            return response()->json(['error' => 'لا تتوفر عروض لهذا الرمز'], 404);
        }

        $selectedOffer = $this->selectOfferRandomly($offers);

        if (!$selectedOffer) {
            return response()->json(['error' => 'فشل في اختيار العرض'], 500);
        }

        OfferUsage::create([
            'offer_id' => $selectedOffer->id,
            'phone_number' => $inputPhone,
        ]);

        $selectedOffer->increment('used_times');

        return response()->json(['success' => $selectedOffer]);
    }

    private function selectOfferRandomly($offers)
    {
        if ($offers->isEmpty()) {
            return null;
        }
        $randomIndex = mt_rand(0, $offers->count() - 1);
        return $offers->get($randomIndex);
    }
}
