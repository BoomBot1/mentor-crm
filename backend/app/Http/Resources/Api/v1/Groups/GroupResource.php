<?php

namespace App\Http\Resources\Api\v1\Groups;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Group $resource
 */

final class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * ID
             *
             * @var string
             */
            'id' => $this->resource->id,

            /**
             * Название группы
             *
             * @var string
             */
            'name' => $this->resource->name,
        ];
    }
}
