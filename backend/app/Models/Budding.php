<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class Budding extends Model
{
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

    public function trainee(): HasOne
    {
        return $this->HasOne(
            User::class,
            'trainee_id',
            'id'
        );
    }
}
