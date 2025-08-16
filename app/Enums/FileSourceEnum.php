<?php

namespace App\Enums;

enum FileSourceEnum: string
{
    case USER_UPLOAD = 'user_upload';
    case ALPHA_PLUGIN = 'alpha_plugin';
}
