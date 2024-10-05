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
                return [
                    'x' => $index % $width,
                    'y' => (int) floor($index / $width),
                    'value' => $cell,
                    'is_mine' => $cell === 'x',
                    'is_flag' => false,
                    'is_revealed' => false,
                ];
            });
        $seed = $seed->map(function (array $cell, $index) use ($width, $seed) {
            if (! $cell['is_mine']) {
                foreach ([$width, 0, -$width] as $offset) {
                    for ($i = -1; $i <= 1; $i++) {
                        if ($i === -1 && $index % $width === 0) {
                            continue;
                        }
                        if ($i === 1 && $index % $width === $width - 1) {
                            continue;
                        }
                        if ($seed->has($index + $offset + $i) && $seed[$index + $offset + $i]['is_mine']) {
                            $cell['value']++;
                        }
                    }
                }
            }

            return $cell;
        });

        $board = Board::create([
            'state' => BoardState::Running,
            'mine_count' => $mines,
            'width' => $width,
            'height' => $height,
        ]);
        Row::insert(array_fill(0, $height, ['board_id' => $board->id]));
        $rows = Row::where('board_id', $board->id)->get();
        $cells = $seed
            ->chunk($width)
            ->flatMap(function ($chunk, $index) use ($rows) {
                return $chunk->map(function ($cell) use ($rows, $index) {
                    return array_merge($cell, ['row_id' => $rows[$index]->id]);
                });
            })
            ->toArray();
        Cell::insert($cells);

        return $board;
    }
}
