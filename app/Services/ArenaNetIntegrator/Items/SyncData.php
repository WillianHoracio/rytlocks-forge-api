<?php
namespace App\Services\ArenaNetIntegrator\Items;

use App\Models\GameItems\{
    Item,
    ItemFlag,
    ItemGameType,
    ItemRestriction
};

class SyncData
{
    protected DataMapper $dataMapper;

    public function __construct(DataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    public function syncItems(array $items)
    {
        $data = $this->dataMapper->mapAll($items);

        $this->persistItems($data['items']);
        $this->persistFlags($data['flags']);
        $this->persistGameTypes($data['gameTypes']);
        $this->persistRestrictions($data['restrictions']);
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
