<?php

// ┌─────────────────────────────────────────────────────────────────────────────┐
// │                             GW2 Item Service                                │
// │                                                                             │
// │   Handles API requests to Guild Wars 2: items, skins, recipes, and more.    │
// │   Centralizes HTTP calls and response error handling.                       │
// └─────────────────────────────────────────────────────────────────────────────┘

    namespace App\Services;

    use Illuminate\Support\Facades\Http;

    class Gw2ItemService
    {

        protected string $baseUrl = 'https://api.guildwars2.com/v2';

// ┌─────────────────────────────────────────────────────────────────────────────┐
// │                            Finishers Endpoints                              │
// └─────────────────────────────────────────────────────────────────────────────┘

        public function getAllFinishers() 
        {
            $response = Http::get("{$this->baseUrl}/finisher");
            return $this->handleResponse($response);
        }

        public function getFinisher(int $id) 
        {
            $response = Http::get("{$this->baseUrl}/finisher/{$id}");
            return $this->handleResponse($response);
        }

        public function getFinishers(array $ids)
        {
            $response = Http::get("{$this->baseUrl}/finisher", [ "ids" => implode(',', $ids)]);
            return $this->handleResponse($response);
        }

// ┌─────────────────────────────────────────────────────────────────────────────┐
// │                              Items Endpoints                                │
// └─────────────────────────────────────────────────────────────────────────────┘

        public function getItem(int $id)
        {
            $response = Http::get("{$this->baseUrl}/items/{$id}");
            return $this->handleResponse($response);
        }

        public function getItems(array $ids)
        {
            $response = Http::get("{$this->baseUrl}/items", [ "ids" => implode(',', $ids)]);
            return $this->handleResponse($response);
        }

        public function getAllItems()
        {
            $response = Http::get("{$this->baseUrl}/items");
            return $this->handleResponse($response);
        }

// ┌─────────────────────────────────────────────────────────────────────────────┐
// │                            Itemstats Endpoints                              │
// └─────────────────────────────────────────────────────────────────────────────┘

        public function getItemStats($id)
        {   
            $response = Http::get("{$this->baseUrl}/itemstats/{$id}");
            return $this->handleResponse($response);
        }

        public function getItemsStats($ids)
        {
            $response = Http::get("{$this->baseUrl}/itemstats", ["ids" => implode(',', $ids)]);
            return $this->handleResponse($response);
        }

        public function getAllItemStats()
        {
            $response = Http::get("{$this->baseUrl}/itemstats");
            return $this->handleResponse($response);
        }

// ┌─────────────────────────────────────────────────────────────────────────────┐
// │                        Materials Categorys Endpoints                        │
// └─────────────────────────────────────────────────────────────────────────────┘

        public function getMaterialCategory(int $id)
        {
            $response = Http::get("{$this->baseUrl}/materials/{$id}");
            return $this->handleResponse($response);
        }

        public function getAllMaterialCategorys()
        {
            $response = Http::get("{$this->baseUrl}/materials");
            return $this->handleResponse($response);
        }

// ┌─────────────────────────────────────────────────────────────────────────────┐
// │                            Pvp Amulets Endpoints                            │
// └─────────────────────────────────────────────────────────────────────────────┘

        public function getPvpAmulet(int $id)
        {
            $response = Http::get("{$this->baseUrl}/pvp/amulets/{$id}");
            return $this->handleResponse($response);
        }

        public function getAllPvpAmulets(int $page = 0, int $pageSize = 0)
        {
            $params = array_filter([
                'page' => $page > 0 ? $page : null,
                'page_size' => $pageSize > 0 ? $pageSize : null,
            ]);

            $response = Http::get("{$this->baseUrl}/pvp/amulets", $params);
            return $this->handleResponse($response);
        }

// ┌─────────────────────────────────────────────────────────────────────────────┐
// │                              Recipes Endpoints                              │
// └─────────────────────────────────────────────────────────────────────────────┘

        public function getRecipe(int $id)
        {
            $response = Http::get("{$this->baseUrl}/recipes/{$id}");
            return $this->handleResponse($response);
        }

        public function getAllRecipes()
        {
            $response = Http::get("{$this->baseUrl}/recipes");
            return $this->handleResponse($response);
        }

// ┌─────────────────────────────────────────────────────────────────────────────┐
// │                        Search Item Recipes Endpoints                        │
// └─────────────────────────────────────────────────────────────────────────────┘

        public function getRecipeSearch(int $inputId = 0, int $outputId = 0)
        {
            $params = array_filter([
                'input' => $inputId > 0 ? $inputId : null,
                'output' => $outputId > 0 ? $outputId : null
            ]);

            if (!empty($params)) {
                $response = Http::get("{$this->baseUrl}/recipes/search", $params);
                return $this->handleResponse($response);
            }

            throw new \Exception('No params informed on getRecipeSearch endpoint');
        }


        public function getLegendaryArmory()
        {
            $response = Http::get("{$this->baseUrl}/legendaryarmory");
            return $this->handleResponse($response);
        }

        public function getSkin(int $id)
        {
            $response = Http::get("{$this->baseUrl}/skins/{$id}");
            return $this->handleResponse($response);
        }

        public function getItemRecipe(int $id)
        {
            $response = Http::get("{$this->baseUrl}/recipes/{$id}");
            return $this->handleResponse($response);
        }

        protected function handleResponse($response) 
        {
            if ($response->failed()) {
                throw new \Exception('GW2 API Request failed: '.$response->status());
            }

            return $response->json();
        }
    }