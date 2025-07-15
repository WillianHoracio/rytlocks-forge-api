<?php

namespace App\Services\ArenaNetIntegrator\Items;


use App\Services\ArenaNetIntegrator\SyncResolver;
use App\Services\ArenaNetServices\ItemService;
use App\Services\ArenaNetIntegrator\Items\SyncLoggerHelper;
use App\Models\SyncRecord;

class SyncService
{
    protected SyncResolver $syncResolver;
    protected ItemService $itemService;
    protected SyncLoggerHelper $logger;
    protected SyncData $syncData;
    protected array $successfulChunks = [];
    protected array $failedChunks = [];
    protected int   $totalChunks = 0;
    protected int   $progress = 0;

    public function __construct(ItemService $itemService, SyncLoggerHelper $logger, SyncData $syncData, SyncResolver $syncResolver)
    {
        $this->itemService = $itemService;
        $this->logger = $logger;
        $this->syncData = $syncData;
        $this->syncResolver = $syncResolver;
    }

    public function syncItems() 
    {   
        $this->logger->startingSync();
        $ids = $this->itemService->getAllItems();
     
        if (empty($ids)) {
            $this->logger->noItemsToSync();
            return;   
        }

        $ids = $this->syncResolver->getUnsyncedIds($ids, SyncRecord::ITEM);
        $chunks = $this->prepareChunks($ids);
        
        $this->processChunks($chunks);
    }

    protected function prepareChunks(array $ids) : array
    {
        $chunks = array_chunk($ids, 200);
        $this->totalChunks = count($chunks);
        $this->logger->chunksPrepared(count($chunks));
        return $chunks;
    }

    protected function processChunks(array $chunks) : void
    {
        $this->progress = 0;
        foreach ($chunks as $chunk) {
            $this->progress++;
            $this->logger->startingChunk($this->progress, $this->totalChunks);
            
            $items = $this->itemService->getItems($chunk);

            //Tries to sync the chunk items. Returns true if successful.
            if ($this->trySyncItems($items, 3)) {
                foreach ($chunk as $item) {
                    $this->logger->item($item);
                }
                $this->successfulChunks[] = $chunk;
            } else {
                $this->failedChunks[] = $chunk;
                $this->logger->chunkFatalError();
            };
        }
    }

    protected function trySyncItems(array $data, int $maxAttempts) : bool
    {
        if($data) {
            $attempts = 0;
            while($attempts < $maxAttempts) {
                try{
                    $this->syncData->syncItems($data);
                    return true;
                } catch(\Exception $e) {
                    $attempts++;
                    $this->logger->chunkTryError($attempts, $e->getMessage());
                }
            }
        }
        return false;
    }
}
