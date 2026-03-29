<?php

namespace App\Models;

use App\Enums\Reports\ReportStatus;
use Illuminate\Database\Eloquent\Model;

final class Report extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'reports';
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'status' => ReportStatus::class,
        ];
    }
}
