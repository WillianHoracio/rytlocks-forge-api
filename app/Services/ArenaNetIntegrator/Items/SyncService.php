<?php

namespace App\Services\ArenaNetIntegrator\Items;

use App\Services\ArenaNetServices\ItemService;
use App\Services\ArenaNetIntegrator\Items\SyncLoggerHelper;

class SyncService
{
    protected ItemService $itemService;
    protected SyncLoggerHelper $logger;
    protected SyncData $syncData;
    protected array $itemIdsChunks = [];
    protected array $itemsIdsWithErrors = [];
    protected int   $totalChunks = 0;
    protected int   $progress = 0;

    public function __construct(ItemService $itemService, SyncLoggerHelper $logger, SyncData $syncData)
    {
        $this->logger = $logger;
        $this->syncData = $syncData;
        $this->itemService = $itemService;
    }

    public function syncItems() 
    {   
        $this->logger->startingSync();
        $ids = $this->itemService->getAllItems();

        if (count($ids) > 0) {
            $chunks = $this->prepareChunks($ids);
            $this->processChunks($chunks);
        } else {
            $this->logger->noItemsToSync();
        }
    }

    protected function prepareChunks(array $ids)
    {
        $chunks = array_chunk($ids, 200);
        $this->totalChunks = count($chunks);
        $this->logger->chunksPrepared(count($chunks));
        return $chunks;
    }

    protected function processChunks(array $chunks)
    {
        $this->progress = 0;
        foreach ($chunks as $chunk) {
            $this->progress++;
            $this->logger->startingChunk($this->progress, $this->totalChunks);
            
            $itemsData = $this->itemService->getItems($chunk);

            foreach ($chunk as $item) {
                $this->logger->item($item);
            }

            if($itemsData) {
                $this->syncData->syncItems($itemsData);
            }
        }
    }
}
