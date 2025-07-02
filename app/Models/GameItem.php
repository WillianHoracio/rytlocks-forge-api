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

    public function detail()
    {
        return $this->hasOne(GameItemDetail::class);
    }

}
