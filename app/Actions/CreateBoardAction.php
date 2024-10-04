<?php

namespace App\Actions;

use App\Enums\BoardState;
use App\Models\Board;
use App\Models\Cell;
use App\Models\Row;

class CreateBoardAction
{
    public function __invoke(int $width = 16, int $height = 30, int $mines = 99): Board
    {
        $seed = collect([
            ...array_fill(0, $mines, 'x'),
            ...array_fill(0, ($width * $height) - $mines, 0),
        ])
            ->shuffle()
            ->map(function ($cell, $index) use ($width) {
                return Cell::make([
                    'index' => $index,
                    'x' => $index % $width,
                    'y' => (int) floor($index / $width),
                    'value' => $cell,
                    'is_mine' => $cell === 'x',
                    'is_flag' => false,
                    'is_revealed' => false,
                ]);
            });
        $seed = $seed->map(function (Cell $cell, $index) use ($width, $seed) {
            if (! $cell->is_mine) {
                foreach ([$width, 0, -$width] as $offset) {
                    for ($i = -1; $i <= 1; $i++) {
                        if ($seed->has($index + $offset + $i) && $seed[$index + $offset + $i]->is_mine) {
                            $cell->value++;
                        }
                    }
                }
            }

            return $cell;
        });

        $board = Board::create(['state' => BoardState::Running]);
        for ($i = 0; $i < $height; $i++) {
            $row = Row::create(['board_id' => $board->id, 'index' => $i]);
            $chunk = $seed->shift($width);
            $chunk->each(fn (Cell $cell) => $row->cells()->save($cell));
        }

        return $board;
    }
}
