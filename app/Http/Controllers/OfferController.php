<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Resources\OfferResource;
use App\Models\Code;
use App\Models\Shop;
use Hossam\Licht\Controllers\LichtBaseController;
use Illuminate\Http\Request;

class OfferController extends LichtBaseController
{

    public function index()
    {
        $offers = Offer::with(['code', 'shop'])->get();
        $offers = OfferResource::collection($offers);
        $codes = Code::all();
        $shops = Shop::all();
        return view('offers', compact('offers', 'codes', 'shops'));
    }

    public function store(StoreOfferRequest $request)
    {
        $offer = Offer::create($request->validated());
        if ($request->is_code_page) {
            return redirect()->route('codes.show', ['code' => $request->code_id]);
        };
        return redirect()->route('offers.index');
    }

    public function show(Offer $offer)
    {
        return $this->successResponse(OfferResource::make($offer));
    }

    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $offer->update($request->validated());
        if ($request->is_code_page) {
            return redirect()->route('codes.show', ['code' => $request->code_id]);
        };
        return redirect()->route('offers.index');
    }

    public function destroy(Offer $offer, Request $request)
    {
        $offer->delete();
        if ($request->is_code_page) {
            return redirect()->route('codes.show', ['code' => $offer->code_id]);
        };
        return redirect()->route('offers.index');
    }
}
