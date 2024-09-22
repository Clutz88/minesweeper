<?php

namespace App\Actions;

use App\Models\Board;
use App\Models\Cell;
use App\Models\Row;
use Illuminate\Support\Facades\DB;

class UpdateBoardAction
{
    public function execute($board_update): void
    {
        collect($board_update)
            ->filter(fn ($cell) => $cell !== null)
            ->each(fn ($cell) => DB::table("cells")
                ->where("id", $cell['id'])
                ->update($cell)
            );
    }
}
