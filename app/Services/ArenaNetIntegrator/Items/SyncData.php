<?php
namespace App\Services\ArenaNetIntegrator\Items;

use App\Models\GameItems\{
    ItemArmorDetail,
    Item,
    ItemFlag,
    ItemGameType,
    ItemRestriction
};

class SyncData
{
    public function syncItems($items)
    {
        return true;
        $itemsData = [];
        $flagsData = [];
        $gameTypesData = [];
        $restrictionsData = [];

        foreach ($items as $item) {
            $itemId = $item['id'];

            $itemsData[]      = $this->mapItemData($item);
            $flagsData        = array_merge($flagsData, $this->mapFlagData($itemId, $item['flags']));
            $gameTypesData    = array_merge($gameTypesData, $this->mapGameTypeData($itemId, $item['game_type']));
            $restrictionsData = array_merge($restrictionsData, $this->mapRestrictionData($itemId, $item['restriction']));
        }

        $this->persistItems($itemsData);
        $this->persistFlags($flagsData);
        $this->persistRestrictions($restrictionsData);
        $this->persistGameTypes($gameTypesData);
    }

    protected function persistItems(array $items)
    {
        if (!empty($items)) {
            Item::insertOrIgnore($items);
        }
    }

    protected function persistFlags(array $flags)
    {
        if (!empty($flags)) {
            ItemFlag::insertOrIgnore($flags);
        }
    }

    protected function persistRestrictions(array $restrictions)
    {
        if (!empty($restrictions)) {
            ItemRestriction::insertOrIgnore($restrictions);
        }
    }

    protected function persistGameTypes(array $gameTypes)
    {
        if (!empty($gameTypes)) {
            ItemGameType::insertOrIgnore($gameTypes);
        }
    }

    protected function mapItemData($item)
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

    protected function mapGameTypeData($itemId, $gameTypes)
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

    protected function mapFlagData($itemId, $flags)
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

    protected function mapRestrictionData($itemId, $restrictions)
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
