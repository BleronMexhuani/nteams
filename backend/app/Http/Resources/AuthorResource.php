<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'biography' => $this->biography,
            'birthdate' => $this->birthdate,
            'books' => BookResource::collection($this->whenLoaded('books')), // This will include books if they're loaded
        ];
    }
}
