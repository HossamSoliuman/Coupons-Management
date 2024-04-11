<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CodeResource extends JsonResource
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
			'name' => $this->name,
			'shop' => ShopResource::make($this->whenLoaded('shop')),
            'created_at' => $this->created_at,
            'last_update' => $this->updated_at,
        ];
    }
}
