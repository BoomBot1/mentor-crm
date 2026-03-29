<?php

namespace App\Http\Resources\Api\v1\Mentors;

use App\DTOs\IsUserDataDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property IsUserDataDTO $resource
 */
final class MentorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $resource = $this->resource;

        return [];
    }
}
