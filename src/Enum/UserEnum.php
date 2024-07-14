<?php

declare(strict_types=1);

namespace App\Enum;

enum UserEnum: string
{
    case ADMIN = 'ROLE_ADMIN';
    case COLLABORATOR = 'ROLE_COLLABORATOR';
}
