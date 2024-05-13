<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\Offer;
use App\Models\OfferUsage;
use App\Models\Shop;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Spatie\SimpleExcel\Sheet;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;

//code shop offer offerUsage
//output shop used-times unit-cost total-cost
//
class ExportController extends Controller
{
    public function exportPdf(Code $code)
    {
        $code->load(['offers', 'shops']);
        $shopsUsage = $this->getShopsUsage($code);
        $offerIds = $code->offers->pluck('id')->toArray();
        $offersUsagesDetails = OfferUsage::with('offer')->whereIn('offer_id', $offerIds)->orderBy('id', 'desc')->get();

        $pdf = PDF::loadView('exports.offer_usage_details_pdf', compact('offersUsagesDetails', 'code', 'shopsUsage'));
        return $pdf->download('offer_usage_details.pdf');
    }

    private function getShopsUsage($code)
    {
        $shopsUsage = [];
        foreach ($code->shops as $shop) {
            $shopName = $shop->name;
            $offerIds = Offer::where('shop_id', $shop->id)->where('code_id', $code->id)->pluck('id')->toArray();
            $usedTimes = OfferUsage::whereIn('offer_id', $offerIds)->count();
            $unitCost = $shop->pivot->unit_cost;
            $totalCost = $usedTimes * $unitCost;
            $shopsUsage[] = [
                'shop_name' => $shopName,
                'unit_cost' => $unitCost,
                'used_times' => $usedTimes,
                'total_cost' => $totalCost
            ];
        }
        return $shopsUsage;
    }

    private function getCodesUsage($shop)
    {
        $codesUsage = [];
        foreach ($shop->codes as $code) {
            $codeName = $code->name;
            $offerIds = Offer::where('shop_id', $shop->id)->where('code_id', $code->id)->pluck('id')->toArray();
            $usedTimes = OfferUsage::whereIn('offer_id', $offerIds)->count();
            $unitCost = $code->pivot->unit_cost;
            $totalCost = $usedTimes * $unitCost;
            $codesUsage[] = [
                'code_name' => $codeName,
                'unit_cost' => $unitCost,
                'used_times' => $usedTimes,
                'total_cost' => $totalCost
            ];
        }
        return $codesUsage;
    }


    public function exportPdfShop(Shop $shop)
    {
        $shop->load('offers');
        $codesUsage = $this->getCodesUsage($shop);
        $offerIds = Offer::where('shop_id', $shop->id)->pluck('id');
        $offersUsagesDetails = OfferUsage::with('offer')->whereIn('offer_id', $offerIds)->orderBy('id', 'desc')->get();
        $pdf = Pdf::loadView('exports.shop_usage_details_pdf', compact('offersUsagesDetails', 'shop', 'codesUsage'));
        $fileName = $shop->name . '_shop_usage_details_' . Carbon::now()->format('Y M d') . '.pdf';
        return $pdf->download($fileName);
    }

    public function exportExcel(Request $request, Code $code)
    {
        $code->load('offers');
        $offerIds = Offer::where('code_id', $code->id)->pluck('id');
        $offersUsagesDetails = OfferUsage::with('offer.shop')->whereIn('offer_id', $offerIds)->orderBy('id', 'desc')->get();
        $shopsUsage = $this->getShopsUsage($code);
        $filePath = storage_path('app/temp_offer_usage_details.xlsx');
        $writer = SimpleExcelWriter::create($filePath);
        $writer->addRow(['اسم المتجر', 'تكلفة الوحدة', 'عدد المرات المستخدمة', 'التكلفة الإجمالية']); // Header for Shop Usage Summary
        $totalUsedTimes = 0;
        $totalCost = 0;
        foreach ($shopsUsage as $shopUsage) {
            $writer->addRow([$shopUsage['shop_name'], $shopUsage['unit_cost'], $shopUsage['used_times'], $shopUsage['total_cost']]);
            $totalUsedTimes += $shopUsage['used_times'];
            $totalCost += $shopUsage['total_cost'];
        }

        $writer->addRow(['الإجمالي', '', $totalUsedTimes, $totalCost]);

        $writer->addNewSheetAndMakeItCurrent();
        $writer->addRow(['اسم المتجر', 'الاسم', 'الكمية', 'أقصى عدد مرات الاستخدام', 'العدد المستخدم', 'التوقيت']); // Header for Offer Usage Details
        foreach ($offersUsagesDetails as $offerDetails) {
            $writer->addRow([$offerDetails->offer->shop->name, $offerDetails->offer->name, $offerDetails->offer->amount, $offerDetails->offer->max_usage_times, $offerDetails->offer->used_times, $offerDetails->created_at->format('Y M d H:i:s')]);
        }

        $writer->close();
        return response()->download($filePath, 'تفاصيل استخدام العروض.xlsx')->deleteFileAfterSend(true);
    }

    public function exportExcelShop(Request $request, Shop $shop)
    {
        $codesUsage = $this->getCodesUsage($shop);
        $fileName = $shop->name . '_shop_usage_details_' . Carbon::now()->format('Y M d');
        $shop->load('offers');
        $offerIds = Offer::where('shop_id', $shop->id)->pluck('id');
        $offersUsagesDetails = OfferUsage::with('offer.code')->whereIn('offer_id', $offerIds)->orderBy('id', 'desc')->get();
        $filePath = storage_path('app/' . $fileName . '.xlsx');
        $writer = SimpleExcelWriter::create($filePath);

        // Style
        // $border = new Border(
        //     new BorderPart(Border::BOTTOM, Color::LIGHT_BLUE, Border::WIDTH_THIN, Border::STYLE_SOLID),
        //     new BorderPart(Border::LEFT, Color::LIGHT_BLUE, Border::WIDTH_THIN, Border::STYLE_SOLID),
        //     new BorderPart(Border::RIGHT, Color::LIGHT_BLUE, Border::WIDTH_THIN, Border::STYLE_SOLID),
        //     new BorderPart(Border::TOP, Color::LIGHT_BLUE, Border::WIDTH_THIN, Border::STYLE_SOLID)
        // );

        // $style = (new Style())
        //     ->setFontBold()
        //     ->setFontSize(15)
        //     ->setFontColor(Color::BLUE)
        //     ->setShouldWrapText()
        //     ->setBackgroundColor(Color::YELLOW)
        //     ->setBorder($border);

        // Adding Rows
        $writer->addRow(['اسم الكود', 'تكلفة الوحدة', 'عدد المرات المستخدمة', 'التكلفة الإجمالية']);
        $totalUsedTimes = 0;
        $totalCost = 0;
        foreach ($codesUsage as $codeUsage) {
            $writer->addRow([$codeUsage['code_name'], $codeUsage['unit_cost'], $codeUsage['used_times'], $codeUsage['total_cost']]);
            $totalUsedTimes += $codeUsage['used_times'];
            $totalCost += $codeUsage['total_cost'];
        }

        $writer->addRow(['الإجمالي', '', $totalUsedTimes, $totalCost]);
        $writer->addRow([]); // Adding an empty row

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
        return response()->download($filePath, $fileName . '.xlsx')->deleteFileAfterSend(true);
    }
}
