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
                    'index' => $index,
                    'x' => $index % $width,
                    'y' => (int) floor($index / $width),
                    'value' => $cell,
                    'is_mine' => $cell === 'x',
                    'is_flag' => false,
                    'is_revealed' => false,
                ];
            });
        $seed = $seed->map(function ($cell, $index) use ($width, $seed) {
            if (! $cell['is_mine']) {
                foreach ([$width, 0, -$width] as $offset) {
                    for ($i = -1; $i <= 1; $i++) {
                        if ($i === -1 && $index % $width === 0) {
                            continue;
                        }
                        if ($i === 1 && $index % $width === $width - 1) {
                            continue;
                        }
                        if ($seed[$index + $offset + $i]['is_mine'] ?? null) {
                            $cell['value']++;
                        }
                    }
                }
            }

            return $cell;
        });

        $generated_board = collect();
        for ($i = 0; $i < $height; $i++) {
            $row = collect();
            $chunk = $seed->shift($width);
            $chunk->each(function ($cell) use ($row) {
                $row->push($cell);
            });
            $generated_board->push($row);
        }

        $board = Board::create(['state' => BoardState::Running]);
        $generated_board->each(function ($row, $index) use ($board) {
            $saved_row = Row::make(['index' => $index]);
            $board->rows()->save($saved_row);
            $row->each(function ($cell) use ($saved_row) {
                $saved_row->cells()->save(Cell::make($cell));
            });
        });

        return $board;
    }
}
