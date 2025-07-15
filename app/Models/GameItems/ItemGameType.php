<?php

namespace App\Models\GameItems;

use Illuminate\Database\Eloquent\Model;

class ItemGameType extends Model
{
    protected $fillable = [
        'item_id',
        'game_type',
    ];
    protected $connection = 'game-pgsql';

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}
