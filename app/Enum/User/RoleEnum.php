<?php

namespace App\Enum\User;

enum RoleEnum : string
{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
}
