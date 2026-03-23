<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

final class UserObserver
{
    public function creating(User $user): void
    {
        $uuid = Str::uuid();

        $user->id = $uuid;
    }
}
