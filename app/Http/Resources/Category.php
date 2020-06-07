<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'code' => $this->TypeCode,
            'name' => $this->TypeName,
            'category' => $this->category()->select('CategoryName', 'CategoryCode')->get()
        ];

    }
}
