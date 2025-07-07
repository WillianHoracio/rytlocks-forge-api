<?php

namespace App\Services\ArenaNetIntegrator;

use App\Models\{
    GameDetail,
    GameItem,
    GameItemFlag,
    GameItemGameType,
    GameItemRestriciton
};

use App\Services\ArenaNetServices\Gw2ItemService;
use App\Services\ArenaNetIntegrator\Gw2ItemSyncLogging;


class Gw2ItemSyncService
{

    protected $itemService;
    protected $logging;
    protected array $itemIdsChunks;
    protected array $itemsIdsWithErrors;
    protected int $totalChunks;
    protected int $progress;

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
            $chunks = $this->prepareChunks($ids);
            $this->processChunks($chunks);
        } else {
            $this->logging->writeHeader("SYNCHRONIZATION COMPLETED. NO ITEMS WERE RETURNED FROM THE GAME SERVER!");
        }
    }

    protected function prepareChunks(array $ids)
    {
        $chunks = array_chunk($ids, 50);
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
            foreach ($chunk as $item) {
                $this->logging->writeItem($item);
                $itemData = $this->itemService->getItems($chunk);
                if($itemData) {
                    $this->processItemRelationshipData($itemData);
                }
            }
        }
    }

    protected function processItemRelationshipData(array $itemData)
    {
        //Aqui serão baixados os relacionamtos dos itens, como gametypes (preecher tabela pivot), flag, restrictons, status, coisas que precisam de mais consultas de endpoint
        //Depois aplicarei o solid, removendo daqui metodos que dão mais de uma responsabilidade para esta classe, e injetando aqui
    }

}