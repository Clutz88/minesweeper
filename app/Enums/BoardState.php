<?php

namespace App\Enums;

enum BoardState: string
{
    case Running = 'running';
    case Over = 'over';
}
