<?php

namespace App\Models\GameItems;

use Illuminate\Database\Eloquent\Model;

class ItemInfusionSlot extends Model
{
    protected $fillable = [
        'item_id',
        'flag'
    ];
    protected $connection = 'game-pgsql';

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}
