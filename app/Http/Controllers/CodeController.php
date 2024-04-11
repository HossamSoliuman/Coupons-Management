<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Http\Requests\StoreCodeRequest;
use App\Http\Requests\UpdateCodeRequest;
use App\Http\Resources\CodeResource;
use App\Models\Offer;
use App\Models\OfferUsage;
use App\Models\Shop;
use Hossam\Licht\Controllers\LichtBaseController;
use Illuminate\Http\Request;

class CodeController extends LichtBaseController
{

    public function index()
    {
        $codes = Code::with('shop')->get();
        $codes = CodeResource::collection($codes);
        $shops = Shop::all();
        return view('codes', compact('codes', 'shops'));
    }

    public function store(StoreCodeRequest $request)
    {
        $code = Code::create($request->validated());
        if ($request->is_shop_page) {
            return redirect()->route('shops.show', ['shop' => $request->shop_id]);
        };
        return redirect()->route('codes.index');
    }

    public function show(Code $code)
    {
        $code->load('offers');
        $shops = Shop::all();
        return view('code_offers', compact('code', 'shops'));
    }

    public function update(UpdateCodeRequest $request, Code $code)
    {
        $code->update($request->validated());
        if ($request->is_shop_page) {
            return redirect()->route('shops.show', ['shop' => $request->shop_id]);
        };
        return redirect()->route('codes.index');
    }

    public function destroy(Code $code, Request $request)
    {
        $code->delete();
        if ($request->is_shop_page) {
            return redirect()->route('shops.show', ['shop' => $code->shop_id]);
        };
        return redirect()->route('codes.index');
    }
    public function offersUsage(Code $code)
    {
        $code->load('offers');
        $OfferIds = Offer::where('code_id', $code->id)->pluck('id');
        $offersUsagesDetails = OfferUsage::with('offer')->whereIn('offer_id', $OfferIds)->orderBy('id', 'desc')->paginate(10);
        return view('code_offers_usage', compact('offersUsagesDetails', 'code'));
    }
}
