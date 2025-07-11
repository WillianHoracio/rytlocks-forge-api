<?php

namespace App\Services\ArenaNetIntegrator\Items;

use App\Services\ArenaNetServices\ItemService;
use App\Services\ArenaNetIntegrator\Items\SyncLoggingHelper;


class SyncService
{

    protected $itemService;
    protected $logging;
    protected $syncData;
    protected array $itemIdsChunks;
    protected array $itemsIdsWithErrors;
    protected int $totalChunks;
    protected int $progress;

    public function __construct(ItemService $itemService, SyncLoggingHelper $logging, SyncData $syncData)
    {
        $this->logging = $logging;
        $this->syncData = $syncData;
        $this->itemService = $itemService;
    }

    public function sync() 
    {   
        $this->logging->writeHeader("STARTING ITEM SYNCHRONIZATION");
        $ids = $this->itemService->getAllItems();

        if (count($ids) > 0) {
            $chunks = $this->prepareChunks($ids);
            $this->processChunks($chunks);
        } else {
            $this->logging->writeHeader("SYNCHRONIZATION COMPLETED. NO ITEMS WERE RETURNED FROM THE GAME SERVER!");
        }
    }

    protected function prepareChunks(array $ids)
    {
        $chunks = array_chunk($ids, 200);
        $this->totalChunks = count($chunks);
        $this->logging->writeInfo(count($chunks)." chunks prepared. Starting download...");
        return $chunks;
    }

    protected function processChunks(array $chunks)
    {
        $this->progress = 0;
        foreach ($chunks as $chunk) {
            $this->progress++;
            $this->logging->writeSubHeader("Starting Chunk {$this->progress} of {$this->totalChunks}");
            
            $itemsData = $this->itemService->getItems($chunk);

            foreach ($chunk as $item) {
                $this->logging->writeItem($item);
            }

            if($itemsData) {
                $this->storeItems($itemsData);
            }
        }
    }

    protected function storeItems(array $itemsData)
    {
        
        $this->syncData->syncItems($itemsData);
        //echo(print_r($itemsData));   

    }

}