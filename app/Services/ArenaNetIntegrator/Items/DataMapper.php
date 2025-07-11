<?php
namespace App\Services\ArenaNetIntegrator\Items;

class DataMapper
{

    public function mapItemData($item)
    {
        return [
            'id' => $item['id'],
            'name' => $item['name'],
            'description' => $item['description'] ?? null,
            'type' => $item['type'],
            'rarity' => $item['rarity'],
            'vendor_value' => $item['vendor_value'],
            'default_skin' => $item['default_skin'] ?? null,
            'level' => $item['level'],
            'icon' => $item['icon']
        ];
    }

    public function mapGameTypeData($itemId, $gameTypes)
    {
        $data = [];
        foreach ($gameTypes as $gameType) {
            $data[] = [
                'item_id' => $itemId,
                'game_type' => $gameType,
            ];
        }
        return $data;
    }

    public function mapFlagData($itemId, $flags)
    {
        $data = [];
        foreach ($flags as $flag) {
            $data[] = [
                'item_id' => $itemId,
                'flag' => $flag,
            ];
        }
        return $data;
    }

    public function mapRestrictionData($itemId, $restrictions)
    {
        $data = [];
        foreach ($restrictions as $restriction) {
            $data[] = [
                'item_id' => $itemId,
                'restriction' => $restriction
            ];
        }
        return $data;
    }
}