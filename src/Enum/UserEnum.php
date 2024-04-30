<?php

namespace App\Enum;

enum UserEnum : string
{
    case ADMIN = 'ROLE_ADMIN';
    case COLLABORATOR = 'ROLE_COLLABORATOR';
}
