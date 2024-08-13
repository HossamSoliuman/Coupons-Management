<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Code;
use App\Models\OfferUsage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetCodeOffer extends Controller
{
    public function __invoke(Request $request)
    {
        $inputCode = $request->code;
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
