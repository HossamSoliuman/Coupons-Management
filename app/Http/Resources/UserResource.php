<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
			'email' => $this->email,
			'password' => $this->password,
			'shop' => ShopResource::make($this->whenLoaded('shop')),
            'created_at' => $this->created_at,
            'last_update' => $this->updated_at,
        ];
    }
}
