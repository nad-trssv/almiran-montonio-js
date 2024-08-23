<?php

namespace App\Http\Resources;


use App\Libraries\AppLibrary;
use Illuminate\Http\Resources\Json\JsonResource;

class AdministratorResource extends JsonResource
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
            "phone"        => $this->phone,
            "status"       => $this->status,
            "balance"       => AppLibrary::flatAmountFormat($this->balance),
            "role_id"      => optional($this->roles[0])->id,
            "role"         => optional($this->roles[0])->name,
            "image"        => $this->image,
            "country_code" => $this->country_code,
        ];
    }
}
