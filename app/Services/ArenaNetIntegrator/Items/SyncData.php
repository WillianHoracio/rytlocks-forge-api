<?php
namespace App\Services\ArenaNetIntegrator\Items;

use App\Models\GameItems\{
    Item,
    ItemFlag,
    ItemGameType,
    ItemRestriction
};

use App\Services\ArenaNetIntegrator\Items;

class SyncData
{
    protected $dataMapper;

    public function __construct(DataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    public function syncItems($items)
    {
        return true;
        $itemsData = [];
        $flagsData = [];
        $gameTypesData = [];
        $restrictionsData = [];

        foreach ($items as $item) {
            $itemId = $item['id'];

            $itemsData[]      = $this->dataMapper->mapItemData($item);
            $flagsData        = array_merge($flagsData,        $this->dataMapper->mapFlagData($itemId, $item['flags']));
            $gameTypesData    = array_merge($gameTypesData,    $this->dataMapper->mapGameTypeData($itemId, $item['game_type']));
            $restrictionsData = array_merge($restrictionsData, $this->dataMapper->mapRestrictionData($itemId, $item['restriction']));
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
}
