<?php

namespace App\Enum\Course;

enum LevelEnum: string
{
    case DEBUTANT = 'debutant';
    case INTERMEDIAIRE = 'intermediaire';
    case AVANCE = 'avance';
    case EXPERT = 'expert';
}
