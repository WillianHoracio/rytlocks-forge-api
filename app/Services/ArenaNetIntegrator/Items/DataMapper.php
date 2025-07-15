<?php
namespace App\Services\ArenaNetIntegrator\Items;

class DataMapper
{
    public function mapAll(array $items) : array 
    {
        $itemsData = [];
        $flagsData = [];
        $gameTypesData = [];
        $restrictionsData = [];

        foreach ($items as $item) {
            $itemId = $item['id'];
            
            $itemsData[]      = $this->mapItemData($item);
            $flagsData        = array_merge($flagsData,        $this->mapFlagData($itemId, $item['flags']));
            $gameTypesData    = array_merge($gameTypesData,    $this->mapGameTypeData($itemId, $item['game_types']));
            $restrictionsData = array_merge($restrictionsData, $this->mapRestrictionData($itemId, $item['restrictions']));
        }

        return [
            'items'        => $itemsData,
            'flags'        => $flagsData,
            'gameTypes'    => $gameTypesData,
            'restrictions' => $restrictionsData
        ];
    }

    public function mapItemData(array $item) : array
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

    public function mapGameTypeData(int $itemId, ?array $gameTypes) : array
    {
        $data = [];
        if (!$gameTypes) return $data;
        foreach ($gameTypes as $gameType) {
            $data[] = [
                'item_id' => $itemId,
                'game_type' => $gameType,
            ];
        }
        return $data;
    }

    public function mapFlagData(int $itemId, ?array $flags) : array
    {
        $data = [];
        if (!$flags) return $data;
        foreach ($flags as $flag) {
            $data[] = [
                'item_id' => $itemId,
                'flag' => $flag,
            ];
        }
        return $data;
    }

    public function mapRestrictionData(int $itemId, ?array $restrictions) : array
    {
        $data = [];
        if (!$restrictions) return $data;
        foreach ($restrictions as $restriction) {
            $data[] = [
                'item_id' => $itemId,
                'restriction' => $restriction
            ];
        }
        return $data;
    }
}
