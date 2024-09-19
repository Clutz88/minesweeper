<?php

namespace App\Http\Controllers;

use App\Actions\CreateBoardAction;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        $board = app(CreateBoardAction::class)();
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
