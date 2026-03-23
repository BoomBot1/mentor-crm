<?php

namespace App\Enums\Reports;

use Filament\Support\Contracts\HasLabel;

enum ReportStatus: string implements HasLabel

{
    case Saved = 'Saved';
    case Send = 'Send';
    case Failed = 'Failed';
    case Success = 'Success';


    public function getLabel(): string
    {
        return __('enums/repot_status.' . $this->value);
    }
}
