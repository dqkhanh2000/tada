<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductColor;

class GroupProduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        JsonResource::withoutWrapping();
        return [
            'id'=> $this->GroupProductID,
            'name'=> $this->GroupName,
            'code'=> $this->GroupNameNoVN,
            'price'=> (int)str_replace('.', '', str_replace('₫', '', str_replace(',', '', $this->Price))),
            'description'=> $this->Description,
            'sale-off'=> $this->Sale,
            'image' => $this->productByColor()->get()->first()->SmallImage,
            'colors' => ProductColor::collection($this->productByColor()->get()),
            'hot'=> ($this->Sale > 0)
        ];
    }
}
