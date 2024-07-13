<?php

namespace App\Http\Controllers;

use App\Models\OfferUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $offersUsagesDetails = OfferUsage::with('offer.code', 'offer.shop')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('index', compact('offersUsagesDetails'));
    }
    public function chartData()
    {
        $today = Carbon::now();
        $offerUsageData = OfferUsage::whereDate('created_at', $today->toDateString())
            ->selectRaw("HOUR(created_at) as hour, COUNT(*) as count")
            ->groupBy(DB::raw("HOUR(created_at)"))
            ->get();
        return response()->json($offerUsageData);
    }
}
