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

/**
 * @property string $id
 * @property string|null $name
 * @property string $email
 * @property Collection|null $contact
 * @property RoleType|null $role
 * @property bool $remote
 * @property bool $is_active
 * @property string|null $group_id
 * @property string|null $vacation_until
 * @property string|null $last_login_at
 * @property string|null $last_action_at
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Budding> $buddings
 * @property-read int|null $buddings_count
 * @property-read \App\Models\Group|null $group
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonalRefreshToken> $refreshTokens
 * @property-read int|null $refresh_tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastActionAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRemote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereVacationUntil($value)
 * @mixin \Eloquent
 */
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
