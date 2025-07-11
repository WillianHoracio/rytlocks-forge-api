<?php

namespace App\Models\GameItems;

use Illuminate\Database\Eloquent\Model;

class ItemFlag extends Model
{
    protected $fillable = [
        'item_id',
        'flag',
    ];
    protected $connection = 'game-pgsql';

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}
