<?php

    namespace App\Services;

    use Illuminate\Support\Facades\Http;

    class Gw2ItemService
    {

        protected string $baseUrl = 'https://api.guildwars2.com/v2';

        public function getAllItems()
        {
            return Http::get("{$this->baseUrl}/items");
        }

        public function getItem(int $id)
        {
            return Http::get("{$this->baseUrl}/items/{$id}");
        }

        public function getItems(array $ids)
        {
            return Http::get("{$this->baseUrl}/items", [ "ids" => implode(',', $ids)]);
        }

        public function getLegendaryArmory()
        {
            return Http::get("{$this->baseUrl}/legendaryarmory");
        }

        public function getSkin(int $id)
        {
            return Http::get("{$this->baseUrl}/skins/{$id}");
        }

        public function getItemRecipe(int $id)
        {
            return Http::get("{$this->baseUrl}/recipes/{$id}");
        }
    }