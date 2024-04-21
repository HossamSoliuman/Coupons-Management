<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Offer;
use App\Models\OfferUsage;
use App\Models\Shop;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function exportPdf(Code $code)
    {
        $code->load('offers');
        $offerIds = Offer::where('code_id', $code->id)->pluck('id');
        $offersUsagesDetails = OfferUsage::with('offer')->whereIn('offer_id', $offerIds)->orderBy('id', 'desc')->get();
        $pdf = Pdf::loadView('exports.offer_usage_details_pdf', compact('offersUsagesDetails', 'code'));
        return $pdf->download('offer_usage_details.pdf');
    }
    public function exportExcel(Request $request, Code $code)
    {
        $code->load('offers');
        $offerIds = Offer::where('code_id', $code->id)->pluck('id');
        $offersUsagesDetails = OfferUsage::with('offer.shop')->whereIn('offer_id', $offerIds)->orderBy('id', 'desc')->get();
        $filePath = storage_path('app/temp_offer_usage_details.xlsx');
        $writer = SimpleExcelWriter::create($filePath);
        $writer->addRow(['اسم المتجر', 'اسم العرض', 'كميه العرض', 'أقصى مرات الاستخدام', 'عدد المرات المستخدمة', 'الوقت']);
        foreach ($offersUsagesDetails as $offerDetails) {
            $writer->addRow([
                $offerDetails->offer->shop->name,
                $offerDetails->offer->name,
                $offerDetails->offer->amount,
                $offerDetails->offer->max_usage_times,
                $offerDetails->offer->used_times,
                $offerDetails->created_at->format('Y M d H:i:s')
            ]);
        }
        $writer->close();
        return response()->download($filePath, 'تفاصيل استخدام العروض.xlsx')->deleteFileAfterSend(true);
    }
    public function exportPdfShop(Shop $shop)
    {
        $shop->load('offers');
        $offerIds = Offer::where('shop_id', $shop->id)->pluck('id');
        $offersUsagesDetails = OfferUsage::with('offer')->whereIn('offer_id', $offerIds)->orderBy('id', 'desc')->get();
        $pdf = Pdf::loadView('exports.shop_usage_details_pdf', compact('offersUsagesDetails', 'shop'));
        return $pdf->download('offer_usage_details.pdf');
    }
    public function exportExcelShop(Request $request, Shop $shop)
    {
        $shop->load('offers');
        $offerIds = Offer::where('shop_id', $shop->id)->pluck('id');
        $offersUsagesDetails = OfferUsage::with('offer.code')->whereIn('offer_id', $offerIds)->orderBy('id', 'desc')->get();
        $filePath = storage_path('app/temp_shop_usage_details.xlsx');
        $writer = SimpleExcelWriter::create($filePath);
        $writer->addRow(["رقم الهاتف", 'اسم الكود', 'اسم العرض', 'كميه العرض', 'أقصى مرات الاستخدام', 'عدد المرات المستخدمة', 'الوقت']);
        foreach ($offersUsagesDetails as $offerDetails) {
            $writer->addRow([
                $offerDetails->phone_number,
                $offerDetails->offer->code->name,
                $offerDetails->offer->name,
                $offerDetails->offer->amount,
                $offerDetails->offer->max_usage_times,
                $offerDetails->offer->used_times,
                $offerDetails->created_at->format('Y M d H:i:s')
            ]);
        }
        $writer->close();
        return response()->download($filePath, 'تفاصيل استخدام العروض.xlsx')->deleteFileAfterSend(true);
    }
}
