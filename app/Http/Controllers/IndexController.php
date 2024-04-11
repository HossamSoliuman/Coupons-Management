<?php

namespace App\Http\Controllers;

use App\Models\OfferUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        // Calculate time range of data
        $minCreatedAt = OfferUsage::min('created_at');
        $maxCreatedAt = OfferUsage::max('created_at');

        // Calculate interval size based on time range
        $interval = $this->calculateIntervalSize($minCreatedAt, $maxCreatedAt);

        $offerUsageData = OfferUsage::selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00') as interval_start, COUNT(*) as count")
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:00')"))
            ->get();



        return response()->json($offerUsageData);
    }

    /**
     * Calculate interval size based on time range.
     */
    private function calculateIntervalSize($minDate, $maxDate)
    {
        $minDate = new \DateTime($minDate);
        $maxDate = new \DateTime($maxDate);

        $interval = 3600; // Default interval size: 1 hour

        $timeRange = $maxDate->getTimestamp() - $minDate->getTimestamp();
        $maxIntervals = 10; // Maximum intervals to display

        // Adjust interval size if needed
        if ($timeRange > 0) {
            $interval = max(1, (int)($timeRange / $maxIntervals));
        }

        return $interval;
    }
    public function offersUsage()
    {
        $offersUsagesDetails = OfferUsage::with('offer.code', 'offer.shop')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('index', compact('offersUsagesDetails'));
    }
}
