<?php

namespace App\Services\ArenaNetIntegrator;

use App\Models\GameItem;
use App\Services\ArenaNetServices\Gw2ItemService;
use App\Services\ArenaNetIntegrator\Gw2ItemSyncLogging;

class Gw2ItemSyncService
{

    protected $itemService;
    protected $logging;
    protected array $itemIdsChunks;
    protected array $itemsIdsWithError;

    public function __construct(Gw2ItemService $itemService, Gw2ItemSyncLogging $logging)
    {
        $this->itemService = $itemService;
        $this->logging = $logging;
    }

    public function sync() 
    {   
        $this->logging->writeHeader("STARTING ITEM SYNCHRONIZATION");
        $ids = $this->itemService->getAllItems();

        if (count($ids) > 0) {
            $this->parseItems($ids);
        } else {
            $this->logging->writeHeader("SYNCHRONIZATION COMPLETED. NO ITEMS WERE RETURNED FROM THE GAME SERVER!");
        }
    }

    protected function parseItems(array $ids)
    {
        $chunks = array_chunk($ids, 100);
        $totalChunks = count($chunks);
        $this->logging->writeInfo("{$totalChunks} chunks prepared. Starting download...");
    }

}