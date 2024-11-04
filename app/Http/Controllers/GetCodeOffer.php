<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\OfferUsage;
use App\Models\Shop;
use App\Services\OtpService;
use App\Models\VerifiedPhone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\ApiResponse;

class GetCodeOffer extends Controller
{
    use ApiResponse;
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function verifyPhone(Request $request)
    {
        $inputCode = $request->code;
        $inputPhone = $request->phone;
        $qrKey = $request->qrKey;

        if ($this->otpService->checkIsVerified($inputPhone)) {
            return response()->json([
                'verified' => 1
            ]);
        } else {
            $message = $this->otpService->sendOtp($inputPhone, $inputCode, $qrKey);
            return response()->json([
                'verified' => 0,
                'message' => $message,
            ]);
        }
    }

    public function verifyOtp(Request $request)
    {
        $phone = $request->phone;
        $otp = $request->otp;
        return $result = $this->otpService->verify($phone, $otp);
    }

    public function getOffer(Request $request)
    {
        $inputCode = Str::upper($request->code);
        $inputPhone = $request->phone;
        $shop = Shop::where('qr_key', $request->qrKey)->first();
        $shopId = $shop->id;

        $code = Code::with(['offers', 'shops'])
            ->where(DB::raw('BINARY name'), $inputCode)
            ->whereHas('shops', function ($query) use ($shopId) {
                $query->where('shop_id', $shopId);
            })
            ->first();


        if (!$code) {
            return $this->apiResponse(null, 'الرمز غير موجود', 0);
        }

        if (!$code->is_active) {
            return $this->apiResponse(null, 'الرمز غير مفعل في الوقت الحالي', 0);
        }

        $usedOffersByPhone = OfferUsage::with('offer.code')
            ->where('phone_number', $inputPhone)
            ->whereHas('offer.code', function ($query) use ($code, $shopId) {
                $query->where('code_id', $code->id)->where('shop_id', $shopId);
            })
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->get();

        if (!$usedOffersByPhone->isEmpty()) {
            return $this->apiResponse(null, 'لقد تم استخدام هذا الكود خلال اقل من يوم', 0);
        }



        $offers = $code->offers()
            ->where('used_times', '<', DB::raw('max_usage_times'))
            ->get();

        if ($offers->isEmpty()) {
            return $this->apiResponse(null, 'لا تتوفر عروض لهذا الرمز', 0);
        }

        $selectedOffer = $this->selectOfferRandomly($offers);

        if (!$selectedOffer) {
            return $this->apiResponse(null, 'فشل في اختيار العرض', 0);
        }

        OfferUsage::create([
            'offer_id' => $selectedOffer->id,
            'phone_number' => $inputPhone,
        ]);

        $selectedOffer->increment('used_times');
        return $this->apiResponse($selectedOffer);
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
