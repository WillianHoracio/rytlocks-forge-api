<?php
namespace App\Services\ArenaNetIntegrator\Items;

use Illuminate\Support\Facades\DB;
use App\Models\SyncRecord;
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

    public function syncItems(array $items, array $chunk = [])
    {
        $data = $this->dataMapper->mapAll($items, $chunk);

        DB::connection('game-pgsql')->transaction(function () use ($data) {
            $this->persistItems($data['items']);
            $this->persistFlags($data['flags']);
            $this->persistGameTypes($data['gameTypes']);
            $this->persistRestrictions($data['restrictions']);
            $this->registerItemSync($data['chunk']);
        });
    }

    protected function registerItemSync(array $chunk)
    {
        if (!empty($chunk)) {
            SyncRecord::insert($chunk);
        }
    }

    protected function persistItems(array $items)
    {
        if (!empty($items)) {
            Item::insert($items);
        }
    }

    protected function persistFlags(array $flags)
    {
        if (!empty($flags)) {
            ItemFlag::insert($flags);
        }
    }

    protected function persistRestrictions(array $restrictions)
    {
        if (!empty($restrictions)) {
            ItemRestriction::insert($restrictions);
        }
    }

    protected function persistGameTypes(array $gameTypes)
    {
        if (!empty($gameTypes)) {
            ItemGameType::insert($gameTypes);
        }
    }
}
