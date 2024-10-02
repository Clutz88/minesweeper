<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cell extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_revealed',
        'is_flag',
    ];

    public function row(): BelongsTo
    {
        return $this->belongsTo(Row::class);
    }
}
