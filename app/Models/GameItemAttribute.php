<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameItemAttribute extends Model
{
    protected $fillable = [
        'attribute',
        'modifier',
        'infix_id'
    ];
    protected $connection = 'game-pgsql';

    public function infix()
    {
        return $this->belongsTo(GameItemInfixUpgrade::class);
    }
}
