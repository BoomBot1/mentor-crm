<?php

namespace App\Models;

use App\Casts\AsUserContactsCollection;
use App\Enums\Users\RoleType;
use App\Observers\UserObserver;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements AuthorizableContract, Contracts\HasApiTokens
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, Concerns\HasApiTokens;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => RoleType::class,
            'contact' => AsUserContactsCollection::class,
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(
            Group::class,
            'group_id',
            'id'
        );
    }

    public function buddings(): HasMany
    {
        return $this->hasMany(Budding::class, 'mentor_id');
    }

    public function getBuddingsToday(): Collection
    {
        return $this
            ->buddings()
            ->where('start_at', '>', Carbon::today())
            ->where('end_at', '<', Carbon::tomorrow())
            ->get();
    }
}
