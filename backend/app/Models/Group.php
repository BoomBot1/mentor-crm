<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

final class Group extends Model
{

    public $timestamps = false;
    protected $table = 'groups';
    protected $guarded = ['id'];

    public function users(): HasMany
    {
        return $this->hasMany(
            User::class ,
            'group_id',
            'id'
        );
    }

    public function backoffices(): HasMany
    {
        return $this->hasMany(
            Backoffice::class,
            'group_id',
            'id'
        );
    }

    public function trainees(): HasMany
    {
        return $this->hasMany(
            Trainee::class,
            'group_id',
            'id'
        );
    }

    public function employees(): Collection
    {
        $this->loadMissing(['users', 'backoffices', 'trainees']);

        return $this->users
            ->concat($this->backoffices)
            ->concat($this->trainees)
            ->values();
    }
}
