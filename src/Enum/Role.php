<?php

namespace App\Enum;


enum Role: string
{
    case Admin = 'ROLE_ADMIN';
    case User = 'ROLE_USER';
}
