<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductColor extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $images = [];
        $sizes = [];

        foreach($this->product()->get() as $size)
            array_push($sizes, array(
                "id" => $size->ProductID,
                "size" => $size->Size,
                "available" => $size->QuantityStorage > 0
            ));

        foreach($this->productImage()->get() as $image)
            array_push($images, $image->Path);
        JsonResource::withoutWrapping();
        return [
            'id'=> $this->ProductByColorID,
            'color'=> $this->Color,
            'images'=> $images,
            'sizes' =>$sizes
        ];
    }
}
