<?php

namespace App\Models;

use App\Enums\Reports\ReportStatus;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read string $id
 *
 * @property string|null $trainee_id
 * @property string|null $mentor_id
 * @property string|null $data
 * @property ReportStatus $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder<static>|Report query()
 *
 * @mixin Eloquent
 */
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
