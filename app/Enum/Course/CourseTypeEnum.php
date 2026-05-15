<?php

namespace App\Enum\Course;

enum CourseTypeEnum: string
{
    case PDF = 'pdf';
    case VIDEO = 'video';
    case AUDIO = 'audio';
}
