<?php

namespace App\Models\GameItems;

use Illuminate\Database\Eloquent\Model;

class InfixUpgradeAttribute extends Model
{
    protected $fillable = [
        'attribute',
        'modifier',
        'infix_id'
    ];
    protected $connection = 'game-pgsql';

    public function infix()
    {
        return $this->belongsTo(InfixUpgrade::class);
    }
}
