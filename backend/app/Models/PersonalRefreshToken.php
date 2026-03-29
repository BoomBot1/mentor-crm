<?php

namespace App\Models;

use App\Models\Contracts\HasApiTokens;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * @property-read int $id
 * @property string $token
 * @property int|null $access_token_id
 * @property Carbon|null $expires_at
 * @property-read HasApiTokens|null $tokenable
 * @property-read PersonalAccessToken|null $accessToken
 * @method static Builder<static>|PersonalRefreshToken query()
 * @property string $tokenable_type
 * @property string $tokenable_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|PersonalRefreshToken newModelQuery()
 * @method static Builder<static>|PersonalRefreshToken newQuery()
 * @method static Builder<static>|PersonalRefreshToken whereAccessTokenId($value)
 * @method static Builder<static>|PersonalRefreshToken whereCreatedAt($value)
 * @method static Builder<static>|PersonalRefreshToken whereExpiresAt($value)
 * @method static Builder<static>|PersonalRefreshToken whereId($value)
 * @method static Builder<static>|PersonalRefreshToken whereToken($value)
 * @method static Builder<static>|PersonalRefreshToken whereTokenableId($value)
 * @method static Builder<static>|PersonalRefreshToken whereTokenableType($value)
 * @method static Builder<static>|PersonalRefreshToken whereUpdatedAt($value)
 * @mixin Eloquent
 */
final class PersonalRefreshToken extends Model
{
    protected $table = 'personal_refresh_tokens';

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected $fillable = [
        'access_token_id',
        'token',
        'expires_at',
    ];

    protected $hidden = [
        'access_token_id',
        'token',
    ];

    public function tokenable(): MorphTo
    {
        return $this->morphTo('tokenable');
    }

    public function accessToken(): BelongsTo
    {
        return $this->belongsTo(PersonalAccessToken::class, 'access_token_id', 'id');
    }

    /**
     * Find the token instance matching the given token.
     *
     * @return static|null
     */
    public static function findToken(string $token): ?PersonalRefreshToken
    {
        $now = now();

        if (!str_contains($token, '|')) {
            return self::where('expires_at', '>', $now)->where('token', hash('sha256', $token))->first();
        }

        [$id, $token] = explode('|', $token, 2);

        if ($instance = self::query()->where('expires_at', '>', $now)->find($id)) {
            return hash_equals($instance->token, hash('sha256', $token)) ? $instance : null;
        }

        return null;
    }
}
