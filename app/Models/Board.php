<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Board extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rows(): HasMany
    {
        return $this->hasMany(Row::class, 'board_id');
    }

    public function cells(): HasManyThrough
    {
        return $this->through('rows')->has('cells');
    }
}
