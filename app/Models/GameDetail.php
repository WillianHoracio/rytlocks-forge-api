<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameItemDetail extends Model
{
    protected $fillable = [
        'item_id',
        'details_json',
    ];

    public function item()
    {
        return $this->belongsTo(GameItem::class);
    }
}
