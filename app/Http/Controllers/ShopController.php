<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Code;
use App\Models\CodeShop;
use App\Models\Offer;
use App\Models\OfferUsage;
use Hossam\Licht\Controllers\LichtBaseController;
use Illuminate\Http\Request;

class ShopController extends LichtBaseController
{

    public function index()
    {
        $shops = Shop::all();
        $shops = ShopResource::collection($shops);
        return view('shops', compact('shops'));
    }

    public function store(StoreShopRequest $request)
    {
        $shop = Shop::create($request->validated());
        return redirect()->route('shops.index');
    }

    public function show(Shop $shop)
    {
        $shop->load('codes');
        $codes = Code::whereNotIn('id', $shop->codes->pluck('id'))->get();
        return view('shop_codes', compact('shop', 'codes'));
    }

    public function update(UpdateShopRequest $request, Shop $shop)
    {
        $shop->update($request->validated());
        return redirect()->route('shops.index');
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();
        return redirect()->route('shops.index');
    }
    public function codesUsages(Shop $shop)
    {
        $shop->load('offers');
        $OfferIds = Offer::where('shop_id', $shop->id)->pluck('id');
        $offersUsagesDetails = OfferUsage::with('offer')->whereIn('offer_id', $OfferIds)->orderBy('id', 'desc')->paginate(10);
        return view('shops_usages', compact('offersUsagesDetails', 'shop'));
    }
    public function addCode(Request $request)
    {
        $shop_id = $request->shop_id;
        $code_id = $request->code_id;
        CodeShop::create([
            'shop_id' => $shop_id,
            'code_id' => $code_id
        ]);
        return redirect()->route('shops.show', ['shop' => $shop_id]);
    }
    public function removeCode(Request $request, $shop_id)
    {
        $code_id = $request->code_id;
        CodeShop::where('shop_id', $shop_id)->where('code_id', $code_id)->delete();
        return redirect()->route('shops.show', ['shop' => $shop_id]);
    }
    public function codes(Shop $shop)
    {
        $shop->load('codes');
        return response()->json(
            $shop->codes
        );
    }
    public function offers(Shop $shop)
    {
        $shop->load('offers', 'codes');
        return view('shop_offers', compact('shop'));
    }
}
