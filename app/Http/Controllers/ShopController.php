<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Offer;
use App\Models\OfferUsage;
use Hossam\Licht\Controllers\LichtBaseController;

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
        return view('shop_codes', compact('shop'));
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
}
