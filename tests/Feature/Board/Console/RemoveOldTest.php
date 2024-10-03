<?php

use App\Enums\BoardState;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;

it('deletes games that are over', function () {
    $board = provideTestBoard();
    $board->state = BoardState::Over;
    $board->save();

    Artisan::call('remove:old-games');

    assertDatabaseEmpty('boards');
    assertDatabaseEmpty('rows');
    assertDatabaseEmpty('cells');
});

it('keeps games that are running', function () {
    $board = provideTestBoard();
    $board->state = BoardState::Running;
    $board->save();

    Artisan::call('remove:old-games');

    assertDatabaseCount('boards', 1);
    assertDatabaseCount('rows', $board->rows->count());
    assertDatabaseCount('cells', $board->cells->count());
});
