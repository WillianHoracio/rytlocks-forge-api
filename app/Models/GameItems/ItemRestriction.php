<?php

namespace App\Models\GameItems;

use Illuminate\Database\Eloquent\Model;

class ItemRestriction extends Model
{
    protected $fillable = [
        'item_id',
        'restriction',
    ];
    protected $connection = 'game-pgsql';

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}
