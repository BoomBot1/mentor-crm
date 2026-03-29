<?php

namespace App\Http\Resources\Api\v1\Buddings;

use App\Models\Budding;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Budding $resource
 */

final class BuddingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'mentor_id' => $this->resource->mentor_id,

            'trainee_id' => $this->resource->trainee_id,
        ];
    }
}
