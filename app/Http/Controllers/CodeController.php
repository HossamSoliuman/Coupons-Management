<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Http\Requests\StoreCodeRequest;
use App\Http\Requests\UpdateCodeRequest;
use App\Http\Resources\CodeResource;
use App\Models\CodeShop;
use App\Models\Offer;
use App\Models\OfferUsage;
use App\Models\Shop;
use Illuminate\Http\Request;

class CodeController extends Controller
{

    public function index()
    {
        $codes = Code::with('shops')->get();
        $codes = CodeResource::collection($codes);
        $shops = Shop::all();
        return view('codes.index', compact('codes', 'shops'));
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
        $code->load('offers', 'shops');
        $shops = $code->shops;
        return view('codes.offers', compact('code', 'shops'));
    }

    public function update(UpdateCodeRequest $request, Code $code)
    {
        $code->update($request->validated());
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
        return view('codes.offers_usage', compact('offersUsagesDetails', 'code'));
    }
    public function shops(Code $code)
    {
        $code->load('shops');
        $shops = Shop::whereNotIn('id', $code->shops->pluck('id'))->get();
        return view('codes.shops', compact('code', 'shops'));
    }

    public function addShop(Request $request, $code)
    {
        CodeShop::create([
            'code_id' => $code,
            'shop_id' => $request->shop_id,
            'unit_cost' => $request->unit_cost,
        ]);
        return redirect()->route('codes.shops', ['code' => $code]);
    }
    public function removeShop(Request $request, $code)
    {
        CodeShop::where('shop_id', $request->shop_id)->where('code_id', $code)->delete();
        return redirect()->route('codes.shops', ['code' => $code]);
    }
    public  function unitCost(Code $code)
    {
        return $this->apiResponse($code->unit_cost);
    }
}
