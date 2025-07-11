<?php
namespace App\Models\GameItems;

use Illuminate\Database\Eloquent\Model;

class ItemArmorDetail extends Model
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
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function infix() {
        return $this->belongsTo(InfixUpgrade::class, 'infix_id');
    }
}
