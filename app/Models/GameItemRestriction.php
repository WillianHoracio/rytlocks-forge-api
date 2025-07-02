<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameItemRestriction extends Model
{
    protected $fillable = [
        'item_id',
        'restriction',
    ];

    public function item()
    {
        return $this->belongsTo(GameItem::class);
    }

}
