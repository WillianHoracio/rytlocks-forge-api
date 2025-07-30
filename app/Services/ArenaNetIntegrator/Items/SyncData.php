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
    protected SyncValidator $syncValidator;

    public function __construct(DataMapper $dataMapper, SyncValidator $syncValidator)
    {
        $this->dataMapper = $dataMapper;
        $this->syncValidator = $syncValidator;
    }

    /**
     * Persists a chunk of items in the database.
     *
     * @param array $items Raw data returned by the getItems request.
     * @param array $chunk Array of item IDs to update. Improves performance by avoiding reprocessing $items to extract IDs.
     *
     * @return void Throws a database exception on error.
     */
    public function syncItems(array $items, array $chunk)
    {
        $this->syncValidator->validateItems($items);
        $this->syncValidator->validateChunk($chunk);
        
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
        // $chunk assumed non-empty; validated in SyncValidator before calling.
        SyncRecord::insert($chunk);
    }

    protected function persistItems(array $items)
    {
        // $items assumed non-empty; validated in SyncValidator before calling.
        Item::insert($items);
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
