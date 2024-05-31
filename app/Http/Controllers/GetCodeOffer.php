<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Code;
use App\Models\OfferUsage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
// ahmed -> is code exist -> yes -> if
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

    // private function selectOfferRandomly($offers)
    // {
    //     // Filter out offers with maximum usage times reached
    //     $eligibleOffers = $offers->reject(function ($offer) {
    //         return $offer->used_times >= $offer->max_usage_times;
    //     });

    //     // If no eligible offers, return null
    //     if ($eligibleOffers->isEmpty()) {
    //         return null;
    //     }

    //     // Calculate total power (adjusting for used_times)
    //     $totalPower = $eligibleOffers->sum(function ($offer) {
    //         return $offer->power / ($offer->used_times + 1); // Adjusting for used_times
    //     });

    //     // If total power is zero, return null
    //     if ($totalPower <= 0) {
    //         return null;
    //     }

    //     // Assign probabilities to each offer based on power and used_times
    //     $probabilities = [];
    //     foreach ($eligibleOffers as $offer) {
    //         $probabilities[$offer->id] = ($offer->power / ($offer->used_times + 1)) / $totalPower; // Adjusting for used_times
    //     }

    //     // Generate a random value to select an offer based on probabilities
    //     $randomValue = mt_rand() / mt_getrandmax();
    //     $cumulativeProbability = 0;

    //     foreach ($probabilities as $offerId => $probability) {
    //         $cumulativeProbability += $probability;
    //         if ($randomValue <= $cumulativeProbability) {
    //             return $eligibleOffers->where('id', $offerId)->first();
    //         }
    //     }

    //     // If somehow the selection fails, return null
    //     return null;
    // }
    private function selectOfferRandomly($offers)
    {
        if ($offers->isEmpty()) {
            return null;
        }
        $randomIndex = mt_rand(0, $offers->count() - 1);
        return $offers->get($randomIndex);
    }
}
