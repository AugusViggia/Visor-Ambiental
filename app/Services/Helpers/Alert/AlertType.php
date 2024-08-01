<?php

namespace App\Services\Helpers\Alert;

enum AlertType: String
{
    case SUCCESS = 'success';
    case DANGER = 'danger';
    case INFO = 'info';
    case WARNING = 'warning';
}
