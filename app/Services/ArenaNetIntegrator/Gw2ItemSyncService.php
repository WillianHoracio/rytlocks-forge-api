<?php

namespace App\Services\ArenaNetIntegrator;

use App\Models\GameItem;
use App\Services\ArenaNetServices\Gw2ItemService;
use Illuminate\Support\Facades\Log;


class Gw2ItemSyncService
{

    protected $itemService;
    protected array $itemIdsChunks;

    public function __construct(Gw2ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function sync() {
        $ids = $this->itemService->getAllItems();

        $chunks = array_chunk($ids, 100);

        return $chunks;

    }

}