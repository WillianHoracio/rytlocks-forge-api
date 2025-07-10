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
    protected $syncData;
    protected array $itemIdsChunks;
    protected array $itemsIdsWithErrors;
    protected int $totalChunks;
    protected int $progress;

    public function __construct(Gw2ItemService $itemService, Gw2ItemSyncLogging $logging, Gw2ItemSyncData $syncData)
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
                $this->processItemRelationshipData($itemsData);
            }
        }
    }

    protected function processItemRelationshipData(array $itemsData)
    {
        
        $this->syncData->store($itemsData);
        //echo(print_r($itemsData));   
        //Aqui serão baixados os relacionamtos dos itens, como gametypes (preecher tabela pivot), flag, restrictons, status, coisas que precisam de mais consultas de endpoint
        //Depois aplicarei o solid, removendo daqui metodos que dão mais de uma responsabilidade para esta classe, e injetando aqui

        /*
            [54] => Array
        (
            [name] => Carrion Conjurer Chest of Lyssa
            [description] =>
            [type] => Armor
            [level] => 80
            [rarity] => Rare
            [vendor_value] => 297
            [default_skin] => 63
            [game_types] => Array
                (
                    [0] => Activity
                    [1] => Wvw
                    [2] => Dungeon
                    [3] => Pve
                )

            [flags] => Array
                (
                    [0] => SoulBindOnUse
                )

            [restrictions] => Array
                (
                )

            [id] => 505
            [chat_link] => [&AgH5AQAA]
            [icon] => https://render.guildwars2.com/file/76CD08463A05730071D400254141B50E570662D3/61023.png
            [details] => Array
                (
                    [type] => Coat
                    [weight_class] => Light
                    [defense] => 278
                    [infusion_slots] => Array
                        (
                        )

                    [attribute_adjustment] => 339.552
                    [infix_upgrade] => Array
                        (
                            [id] => 160
                            [attributes] => Array
                                (
                                    [0] => Array
                                        (
                                            [attribute] => Power
                                            [modifier] => 85
                                        )

                                    [1] => Array
                                        (
                                            [attribute] => Vitality
                                            [modifier] => 85
                                        )

                                    [2] => Array
                                        (
                                            [attribute] => ConditionDamage
                                            [modifier] => 119
                                        )

                                )

                        )

                    [suffix_item_id] => 24775
                    [secondary_suffix_item_id] =>
                )

        )

        */
    }

}