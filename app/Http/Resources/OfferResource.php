<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
			'code' => CodeResource::make($this->whenLoaded('code')),
			'shop' => ShopResource::make($this->whenLoaded('shop')),
			'name' => $this->name,
			'amount' => $this->amount,
			'max_usage_times' => $this->max_usage_times,
			'used_times' => $this->used_times,
            'created_at' => $this->created_at,
            'last_update' => $this->updated_at,
        ];
    }
}
