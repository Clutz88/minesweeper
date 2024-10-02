<?php

namespace App\Http\Controllers;

use App\Actions\CreateBoardAction;
use App\Actions\UpdateBoardAction;
use App\Http\Resources\BoardResource;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index() {}

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $board = app(CreateBoardAction::class)();

        return to_route('board.show', $board);
    }

    public function show(Board $board)
    {
        $board->load('rows', 'rows.cells');

        return inertia('Board/Show', ['board' => BoardResource::make($board)]);
    }

    public function edit($id) {}

    public function update(Request $request, Board $board)
    {
        app(UpdateBoardAction::class)->execute($board, $request->input('updates'));
    }

    public function destroy($id) {}
}
