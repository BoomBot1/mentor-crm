<?php

namespace App\Models;

use Database\Factories\TraineeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property-read string $id
 *
 * @property string $mail
 * @property int $capabilities
 * @property string|null $group_after
 * @property bool $is_office
 * @property bool $is_active
 * @property string|null $group_id
 * @property string|null $last_report_id
 * @property string|null $study_start_at
 * @property string|null $study_end_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Group|null $group
 *
 * @method static TraineeFactory factory($count = null, $state = [])
 *
 * @method static Builder<static>|Trainee query()
 *
 * @mixin Eloquent
 */
final class Trainee extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'trainees';
    protected $guarded = ['id', 'created_at'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(
            Group::class,
            'group_id',
            'id'
        );
    }
}
