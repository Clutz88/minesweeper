<?php

namespace App\Http\Resources;

use App\Models\Cell;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Cell */
class CellResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'index' => $this->index,
            'is_flag' => $this->is_flag,
            'is_mine' => $this->is_mine,
            'is_revealed' => $this->is_revealed,
            'value' => $this->value,
            'x' => $this->x,
            'y' => $this->y,
        ];
    }
}
