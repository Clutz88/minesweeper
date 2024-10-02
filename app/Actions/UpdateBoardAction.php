<?php

namespace App\Actions;

use App\Models\Board;

class UpdateBoardAction
{
    public function execute(Board $board, $board_update): void
    {
        $cells = $board->cells()->whereIn('cells.id', array_column($board_update, 'id'))->get();
        collect($board_update)
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
                    $board->state = 'over';
                    $board->save();
                }
            });
    }
}
