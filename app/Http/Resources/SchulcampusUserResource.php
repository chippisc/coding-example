<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property ?int $id
 * @property ?string $given_name
 * @property ?string $family_name
 */
class SchulcampusUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->given_name.' '.$this->family_name,
        ];
    }
}
