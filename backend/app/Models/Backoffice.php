<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Backoffice extends Model
{
    protected $table = 'backoffices';
    protected $guarded = ['id', 'created_at'];

    public function group(): BelongsTo
    {
        return $this->BelongsTo(
            Group::class,
            'group_id',
            'id'
        );
    }
}
