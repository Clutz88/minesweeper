<?php

namespace App\Actions;

use App\Enums\BoardState;
use App\Models\Board;
use Illuminate\Support\Collection;

class UpdateBoardAction
{
    public function execute(Board $board, Collection $board_update): void
    {
        $cells = $board->cells()->whereIn('cells.id', $board_update->pluck('id'))->get();
        $board_update
            ->filter(fn ($cell) => $cell !== null)
            ->each(fn ($cell) => $cells->where('id', $cell['id'])
                ->first()
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
    }
}
