<?php

// ┌─────────────────────────────────────────────────────────────────────────────┐
// │                             GW2 Item Service                                │
// │                                                                             │
// │   Handles API requests to Guild Wars 2: items, skins, recipes, and more.    │
// │   Centralizes HTTP calls and response error handling.                       │
// └─────────────────────────────────────────────────────────────────────────────┘

namespace App\Services\ArenaNetServices;

use Illuminate\Support\Facades\Cache;
use App\Exceptions\Gw2ApiException;
use App\Services\ArenaNetServices\Validator;
use App\Services\ArenaNetServices\HttpClient;
use App\Services\ArenaNetServices\CachingHelper;

class ItemService
{

    protected $cacheTimer;
    protected $validator;
    protected $httpClient;
    protected $cachingHelper;
    protected $url;

    public function __construct(Validator $validator, HttpClient $httpClient, CachingHelper $cachingHelper)
    {
        $this->validator = $validator;
        $this->httpClient = $httpClient;
        $this->cachingHelper = $cachingHelper;
        $this->cacheTimer = config('gw2Api.api_cache_time');
        $this->url = config('gw2Api.api_base_url') . config('gw2Api.api_version');
    }

    public function getAllFinishers() 
    {
        return Cache::remember("allFinishers", $this->cacheTimer, function (){
            return $this->httpClient->get($this->url."/finisher");
        });
    }

    public function getFinisher(int $id) 
    {
        $this->validator->validateId($id);
        return Cache::remember("finisher_{$id}", $this->cacheTimer, function () use ($id){
            return $this->httpClient->get($this->url."/finisher/{$id}");
        });
    }

    public function getFinishers(array $ids)
    {
        $this->validator->validateIds($ids);
        return $this->httpClient->get($this->url."/finisher", [ "ids" => implode(',', $ids)]);
    }

    public function getItem(int $id)
    {
        $this->validator->validateId($id);
        return Cache::remember("item_{$id}", $this->cacheTimer, function () use ($id){
            return $this->httpClient->get($this->url."/items/{$id}");
        });
    }

    public function getItems(array $ids)
    {
        $this->validator->validateIds($ids);

        $cache = $this->cachingHelper->verifyItemsCached($ids);

        if (empty($cache['uncachedIds'])) {
            return $cache['cachedIds'];
        }

        $fetchedItems = $this->httpClient->get($this->url . "/items", ["ids" => implode(',', $cache['uncachedIds'])]);

        foreach ($fetchedItems as $item) {
            Cache::put("item_{$item['id']}", $item, $this->cacheTimer);
        }

        return array_merge($cache['cachedIds'], $fetchedItems);
    }

    public function getAllItems()
    {
        return Cache::remember("allItems", $this->cacheTimer, function (){
            return $this->httpClient->get($this->url."/items");
        });
    }

    public function getItemStats(int $id)
    {   
        $this->validator->validateId($id);
        return $this->httpClient->get($this->url."/itemstats/{$id}");
    }

    public function getItemsStats(array $ids)
    {
        $this->validator->validateIds($ids);
        return $this->httpClient->get($this->url."/itemstats", ["ids" => implode(',', $ids)]);
    }

    public function getAllItemStats()
    {
        return Cache::remember("allItemStats", $this->cacheTimer, function () {
            return $this->httpClient->get($this->url."/itemstats");
        });
    }

    public function getMaterialCategory(int $id)
    {
        $this->validator->validateId($id);
        return $this->httpClient->get($this->url."/materials/{$id}");
    }

    public function getAllMaterialCategories()
    {
        return Cache::remember("allMaterialCategories", $this->cacheTimer, function (){
            return $this->httpClient->get($this->url."/materials");
        });
    }

    public function getPvpAmulet(int $id)
    {
        $this->validator->validateId($id);
        return $this->httpClient->get($this->url."/pvp/amulets/{$id}");
    }

    public function getAllPvpAmulets(int $page = 0, int $pageSize = 0)
    {
        $params = array_filter([
            'page' => $page > 0 ? $page : null,
            'page_size' => $pageSize > 0 ? $pageSize : null,
        ]);

        return $this->httpClient->get($this->url."/pvp/amulets", $params);
    }

    public function getRecipe(int $id)
    {
        $this->validator->validateId($id);
        return $this->httpClient->get($this->url."/recipes/{$id}");
    }

    public function getAllRecipes()
    {
        return $this->httpClient->get($this->url."/recipes");
    }

    public function getRecipeSearch(int $inputId = 0, int $outputId = 0)
    {
        $params = array_filter([
            'input' => $inputId > 0 ? $inputId : null,
            'output' => $outputId > 0 ? $outputId : null
        ]);

        if (!empty($params)) {
            return $this->httpClient->get($this->url."/recipes/search", $params);
        }

        throw new Gw2ApiException('Error: No inputId or outputId informed on getRecipeSearch endpoint', 000);
    }

    public function getSkin(int $id)
    {
        $this->validator->validateId($id);
        return $this->httpClient->get($this->url."/skins/{$id}");
    }

    public function getAllSkins()
    {
        return Cache::remember("allSkins", $this->cacheTimer, function (){
            return $this->httpClient->get($this->url."/skins");
        });
    }

}