<?php
namespace App\Services\ArenaNetIntegrator;

use App\Models\{
    GameDetail,
    GameItem,
    GameItemFlag,
    GameItemGameType,
    GameItemRestriction
};

class Gw2ItemSyncData
{
    public function store($items)
    {
        $itemsStructure = [];
        $gameTypeStructure = [];
        $flagStructure = [];
        $restrictionStructure = [];

        foreach ($items as $item) {

            $itemsStructure[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'description' => $item['description'] ?? null,
                'type' => $item['type'],
                'rarity' => $item['rarity'],
                'vendor_value' => $item['vendor_value'],
                'default_skin' => $item['default_skin'] ?? null,
                'level' => $item['level'],
                'icon' => $item['icon'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            foreach ($item['game_types'] as $game_type) {
                $gameTypeStructure[] = [
                    'item_id' => $item['id'],
                    'game_type' => $game_type,
                ];
            }

            foreach ($item['flags'] as $flag) {
                $flagStructure[] = [
                    'item_id' => $item['id'],
                    'flag' => $flag,
                ];
            }

            foreach ($item['restrictions'] as $restriction) {
                $restrictionStructure[] = [
                    'item_id' => $item['id'],
                    'restriction' => $restriction
                ];
            }

        }

        if (!empty($itemsStructure)) {
            GameItem::insertOrIgnore($itemsStructure);
            if (!empty($gameTypeStructure)) {
                GameItemGameType::insertOrIgnore($gameTypeStructure);
            }
            if (!empty($flagStructure)) {
                GameItemFlag::insertOrIgnore($flagStructure);
            }
            if (!empty($restrictionStructure)) {
                GameItemRestriction::insertOrIgnore($restrictionStructure);
            }
        }
        /*
[
    54 => [
        'name' => 'Carrion Conjurer Chest of Lyssa',
        'description' => '',
        'type' => 'Armor',
        'level' => 80,
        'rarity' => 'Rare',
        'vendor_value' => 297,
        'default_skin' => 63,
        'game_types' => [
            'Activity',
            'Wvw',
            'Dungeon',
            'Pve',
        ],
        'flags' => [
            'SoulBindOnUse',
        ],
        'restrictions' => [],
        'id' => 505,
        'chat_link' => '[&AgH5AQAA]',
        'icon' => 'https://render.guildwars2.com/file/76CD08463A05730071D400254141B50E570662D3/61023.png',
        'details' => [
            'type' => 'Coat',
            'weight_class' => 'Light',
            'defense' => 278,
            'infusion_slots' => [],
            'attribute_adjustment' => 339.552,
            'infix_upgrade' => [
                'id' => 160,
                'attributes' => [
                    [
                        'attribute' => 'Power',
                        'modifier' => 85,
                    ],
                    [
                        'attribute' => 'Vitality',
                        'modifier' => 85,
                    ],
                    [
                        'attribute' => 'ConditionDamage',
                        'modifier' => 119,
                    ],
                ],
            ],
            'suffix_item_id' => 24775,
            'secondary_suffix_item_id' => '',
        ],
    ],
]
*/

    }
}
    