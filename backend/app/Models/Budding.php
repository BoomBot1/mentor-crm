<?php

namespace App\Models;

use Database\Factories\BuddingFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property-read string|null $mentor_id
 * @property-read string|null $trainee_id
 *
 * @property string $start_at
 * @property string $end_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User|null $mentor
 * @property-read User|null $trainee
 *
 * @method static BuddingFactory factory($count = null, $state = [])
 * @method static Builder<static>|Budding query()
 *
 * @mixin Eloquent
 */
final class Budding extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'buddings';
    protected $guarded = ['id', 'trainee_id', 'mentor_id'];

    public function mentor(): HasOne
    {
        return $this->HasOne(
            User::class,
            'mentor_id',
            'id'
        );
    }

    public function trainee(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'trainee_id',
            'id'
        );
    }
}
