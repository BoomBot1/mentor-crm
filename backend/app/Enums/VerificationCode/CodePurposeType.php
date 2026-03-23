<?php

namespace App\Enums\VerificationCode;

enum CodePurposeType: string
{
    case Auth = 'auth';
    case EmailChange = 'email_change';
}
