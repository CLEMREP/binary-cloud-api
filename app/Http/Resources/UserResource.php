<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /** @var User $resource */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource?->getKey(),
            'firstname' => $this->resource?->firstname,
            'lastname' => $this->resource?->lastname,
            'phone' => $this->resource?->phone,
            'email' => $this->resource?->email,
            'company' => CompanyResource::make($this->whenLoaded('company')),
            'address' => AddressResource::make($this->whenLoaded('address')),
        ];
    }
}
