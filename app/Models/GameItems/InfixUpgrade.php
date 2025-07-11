<?php

namespace App\Models\GameItems;

use Illuminate\Database\Eloquent\Model;

class InfixUpgrade extends Model
{
    protected $connection = 'game-pgsql';
    protected $fillable = [
        'id',
        'skill_id',
        'description'
    ];

    public function attributes() {
        return $this->hasMany(InfixUpgradeAttribute::class);
    }

    public function armorDetail() {
        return $this->hasMany(ItemArmorDetail::class, 'infix_id');
    }
}
