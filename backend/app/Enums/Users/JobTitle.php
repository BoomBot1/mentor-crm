<?php

namespace App\Enums\Users;

use Filament\Support\Contracts\HasLabel;

enum JobTitle: string implements HasLabel
{
    case LS = 'Leading specialist';
    case GL = 'Group leader';
    case MT = 'Mentor';
    case TS = 'Training Specialist';
    case LTS = 'Leading training specialist';
    case TGL = 'Training group leader';

    public function getLabel(): string
    {
        return __('enums/job_title.' . $this->value);
    }
}
