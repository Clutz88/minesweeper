<?php

namespace App\Actions;

use App\Models\Board;
use App\Models\Cell;
use App\Models\Row;

class UpdateBoardAction
{
    public function execute(Board $board, $board_update): void
    {
        dump($board_update);
        foreach ($board_update['rows'] as $row) {
            dump($row);
            foreach ($row['cells'] as $cell_update) {
                dump($cell_update);
                $cell = Cell::find($cell_update['id']);
                $cell->update($cell_update);
            }
        }
    }
}
