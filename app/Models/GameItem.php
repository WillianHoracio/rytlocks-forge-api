<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameItem extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'type',
        'rarity',
        'vendor_value',
        'default_skin',
        'level',
        'icon',
    ];
    protected $connection = 'game-pgsql';

    public function flags()
    {
        return $this->hasMany(GameItemFlag::class);
    }

    public function gameTypes()
    {
        return $this->hasMany(GameItemGameType::class);
    }

    public function restrictions()
    {
        return $this->hasMany(GameItemRestriction::class);
    }

    public function armorDetail()
    {
        return $this->hasOne(GameItemArmorDetail::class, 'item_id');
    }

    public function infusionSlots()
    {
        return $this->hasMany(GameItemInfusionSlot::class, 'item_id');
    }

}
