<?php

namespace App\Actions;

use App\Models\Board;
use Illuminate\Support\Facades\DB;

class UpdateBoardAction
{
    public function execute(Board $board, $board_update): void
    {
        $collection = collect($board_update)
            ->filter(fn ($cell) => $cell !== null)
            ->each(fn ($cell) => DB::table("cells")
                ->where("id", $cell['id'])
                ->update($cell)
            )
            ->pluck('is_mine')
            ->unique()
            ->filter(fn ($cell) => $cell !== 0)
            ->tap(function ($updates) use ($board) {
                if ($updates->isNotEmpty()) {
                    $board->state = 'over';
                    $board->save();
                }
            });

//        if ($collection->pluck('is_mine')->unique()->isNotEmpty()) {
//            $board->state = 'over';
//            $board->save();
//        }
    }
}
