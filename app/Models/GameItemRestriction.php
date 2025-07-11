<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameItemRestriction extends Model
{
    protected $fillable = [
        'item_id',
        'restriction',
    ];
    protected $connection = 'game-pgsql';

    public function item()
    {
        return $this->belongsTo(GameItem::class);
    }

}
