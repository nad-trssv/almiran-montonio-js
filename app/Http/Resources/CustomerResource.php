<?php

namespace App\Http\Resources;


use App\Libraries\AppLibrary;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {


        return [
            "id"           => $this->id,
            "name"         => $this->name,
            "username"     => $this->username,
            "email"        => $this->email,
            "phone"        => $this->phone === null ? '' : $this->phone,
            "balance"       => AppLibrary::flatAmountFormat($this->balance),
            "status"       => $this->status,
            "image"        => $this->image,
            "country_code" => $this->country_code,
        ];
    }
}
