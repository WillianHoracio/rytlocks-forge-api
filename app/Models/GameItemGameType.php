<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameItemGameType extends Model
{
    protected $fillable = [
        'item_id',
        'game_type',
    ];
    protected $connection = 'game-pgsql';

    public function item()
    {
        return $this->belongsTo(GameItem::class);
    }

}
