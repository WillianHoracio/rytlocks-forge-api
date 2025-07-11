<?php

namespace App\Models\GameItems;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
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
        return $this->hasMany(ItemFlag::class);
    }

    public function gameTypes()
    {
        return $this->hasMany(ItemGameType::class);
    }

    public function restrictions()
    {
        return $this->hasMany(ItemRestriction::class);
    }

    public function armorDetail()
    {
        return $this->hasOne(ItemArmorDetail::class, 'item_id');
    }

    public function infusionSlots()
    {
        return $this->hasMany(ItemInfusionSlot::class, 'item_id');
    }

}
