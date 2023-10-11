<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentSearchResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
        ];
    }
}