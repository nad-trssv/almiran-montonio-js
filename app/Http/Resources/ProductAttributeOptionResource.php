<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'name_et'   => $this->name_et,
            'name_ru'   => $this->name_ru,
        ];
    }

}
