<?php

namespace App\Actions;

use App\Enums\BoardState;
use App\Models\Board;
use Illuminate\Support\Collection;

class UpdateBoardAction
{
    public function execute(Board $board, Collection $board_update): Board
    {
        $board_update
            ->filter(fn ($cell) => $cell !== null)
            ->each(fn ($cell) => $board->cells()->where('cells.id', $cell['id'])
                ->update([
                    'is_revealed' => $cell['is_revealed'],
                    'is_flag' => $cell['is_flag'],
                ])
            )
            ->where('is_mine', '=', true)
            ->where('is_revealed', '=', true)
            ->tap(function ($updates) use ($board) {
                if ($updates->isNotEmpty()) {
                    $board->state = BoardState::Over;
                    $board->save();
                }
            });

        if ($board->state === BoardState::Over) {
            return $board;
        }

        if ($board->cells->where('is_mine', false)
            ->where('is_revealed', false)
            ->isEmpty()
        ) {
            $board->state = BoardState::Winner;
            $board->save();
        }

        return $board;
    }
}
