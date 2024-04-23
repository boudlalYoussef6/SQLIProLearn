<?php

namespace App\Enum;

enum UserEnum : string
{
    case ADMIN = 'Admin';
    case COLLABORATOR = 'Collaborator';
}
