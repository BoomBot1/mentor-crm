<?php

namespace App\Enums\Users;

enum RoleType: string
{
    case Mentor = 'mentor';
    case Admin = 'admin';
    case Backoffice = 'backoffice';
    case Trainer = 'trainer';
}
