<?php

namespace App\Exports;

use App\Models\Offer;
use App\Models\Code;
use App\Models\OfferUsage;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OfferUsageExport implements FromCollection, WithHeadings
{
    protected $code;

    public function __construct(Code $code)
    {
        $this->code = $code;
    }

    public function collection()
    {
        $offerIds = Offer::where('code_id', $this->code->id)->pluck('id');

        return OfferUsage::with('offer')
            ->whereIn('offer_id', $offerIds)
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($usage) {
                return [
                    'Usage ID' => $usage->id,
                    'Offer Name' => $usage->offer->name,
                    'Usage Date' => $usage->created_at,
                    // Add more fields as needed
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Usage ID',
            'Offer Name',
            'Usage Date',
            // Add more headings as needed
        ];
    }
}
