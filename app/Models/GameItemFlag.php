<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameItemFlag extends Model
{
    protected $fillable = [
        'item_id',
        'flag',
    ];

    public function item()
    {
        return $this->belongsTo(GameItem::class);
    }

}
