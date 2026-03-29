<?php

namespace App\Http\Resources\Api\v1\Trainees;

use App\Http\Resources\Api\v1\Groups\GroupResource;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Trainee $resource
 */
final class TraineeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $resource = $this->resource;

        return [
            /**
             * ID
             *
             * @var string
             */
            'id' => $resource->id,

            /**
             * Группа
             *
             * @var GroupResource
             */
            'group' => GroupResource::make($resource->group),

            /**
             * Имя
             *
             * @var string
             */
            'name' => $resource->name,

            /**
             * Email
             *
             * @var string
             */
            'email' => $resource->mail,

            /**
             * Способность (от 1 до 100)
             *
             * @var int
             */
            'capabilities' => $resource->capabilities,

            /**
             * В офисе ли
             *
             * @var boolean
             */
            'isOffice' => $resource->is_office,

            /**
             * Работает ли сегодня
             *
             * @var boolean
             */
            'isActive' => $resource->is_active,

            /**
             * ID последнего отчёта по стажёру
             *
             * @var string
             */
            'lastReportId' => $resource->last_report_id,

            /**
             * Начало обучения timestamp
             *
             * @var int
             */
            'studyStartAt' => $resource->study_start_at->timestamp(),

            /**
             * Конец обучения timestamp
             *
             * @var int
             */
            'studyEndAt' => $resource->study_end_at->timestamp(),
        ];
    }
}
