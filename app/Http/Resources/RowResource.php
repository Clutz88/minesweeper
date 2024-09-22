<?php

namespace App\Http\Resources;

use App\Models\Row;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Row */
class RowResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'cells' => CellResource::collection($this->cells),
        ];
    }
}
