<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameItemInfixUpgrade extends Model
{
    protected $connection = 'game-pgsql';
    protected $fillable = [
        'id',
        'skill_id',
        'description'
    ];

    public function attributes() {
        return $this->hasMany(GameItemAttribute::class);
    }

    public function armorDetail() {
        return $this->hasMany(GameItemArmorDetail::class, 'infix_id');
    }
}
