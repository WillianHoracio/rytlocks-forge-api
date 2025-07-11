<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameItemArmorDetail extends Model
{
    protected $table = 'game_item_armor_details';
    protected $connection = 'game-pgsql';

    protected $fillable = [
        'item_id',
        'infix_id',
        'type',
        'weight_class',
        'defense',
        'atribute_adjustment',
        'suffix_item_id',
        'secondary_sufix_item_id'
    ];

    public function gameItem()
    {
        return $this->belongsTo(GameItem::class, 'item_id');
    }

    public function infix() {
        return $this->belongsTo(GameItemInfixUpgrade::class, 'infix_id');
    }
}
