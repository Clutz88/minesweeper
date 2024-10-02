<?php

namespace App\Http\Controllers;

use App\Enums\BoardState;
use App\Models\Board;

class ResetBoardController extends Controller
{
    public function __invoke(Board $board)
    {
        $cells = $board->cells()
            ->where('is_revealed', true)
            ->orWhere('is_flag', true);

        $cells->update(['is_revealed' => false, 'is_flag' => false]);

        $board->update(['state' => BoardState::Running]);
    }
}
