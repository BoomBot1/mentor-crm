<?php

namespace App\Http\Resources\Api\v1\Users;

use App\DTOs\IsUserDataDTO;
use App\Http\Resources\Api\v1\Buddings\BuddingResource;
use App\Http\Resources\Api\v1\Groups\GroupResource;
use App\Http\Resources\Api\v1\Mentors\MentorResource;
use App\Http\Resources\Api\v1\Trainees\TraineeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property IsUserDataDTO $resource
 */
final class UserAccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $resource = $this->resource;

        return [
            /**
             * ID
             *
             * @var string
             *
             * @example
             */
            'id' => $resource->user->id,

            /**
             * Имя
             *
             * @var string
             *
             * @example Иванов Иван Иваныч
             */
            'name' => $resource->user->name,

            /**
             * Роль
             *
             * @var string
             *
             * @example Backoffice
             */
            'role' => $resource->user->role,

            /**
             * Удалёнка
             *
             * @var boolean
             */
            'remote' => $resource->user->remote,

            /**
             * Работает сейчас
             *
             * @var boolean
             */
            'isActive' => $resource->user->is_active,

            /**
             * Группа
             *
             * @var GroupResource
             */
            'group' => GroupResource::make($resource->user->group),

            /**
             * ?Баддинги
             *
             * @var BuddingResource
             */
            'buddings' => property_exists($resource, 'buddings') ? BuddingResource::collection($resource->buddings) : null,

            /**
             * ?Стажёры
             *
             * @var TraineeResource
             */
            'trainees' => property_exists($resource, 'trainees') ? TraineeResource::collection($resource->trainees) : null,

            /**
             * ?Наставники
             *
             * @var MentorResource
             */
            'mentors' => property_exists($resource, 'mentors') ? MentorResource::collection($resource->mentors) : null,
        ];
    }
}
