<?php

namespace App\Http\Resources;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Board */
class BoardResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'state' => $this->state,
            'mine_count' => $this->mine_count,
            'width' => $this->width,
            'height' => $this->height,
            'rows' => RowResource::collection($this->rows),
        ];
    }
}
