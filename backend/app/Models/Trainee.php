<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Trainee extends Model
{
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
