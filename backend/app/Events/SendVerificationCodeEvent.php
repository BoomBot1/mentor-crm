<?php

namespace App\Events;

use App\Enums\VerificationCode\CodePurposeType;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class SendVerificationCodeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly string          $payload,
        public readonly string          $code,
        public readonly CodePurposeType $purposeType,
    )
    {
    }
}
