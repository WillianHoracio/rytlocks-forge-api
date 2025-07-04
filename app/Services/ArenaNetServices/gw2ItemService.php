<?php

// ┌─────────────────────────────────────────────────────────────────────────────┐
// │                             GW2 Item Service                                │
// │                                                                             │
// │   Handles API requests to Guild Wars 2: items, skins, recipes, and more.    │
// │   Centralizes HTTP calls and response error handling.                       │
// └─────────────────────────────────────────────────────────────────────────────┘

namespace App\Services\ArenaNetServices;

use App\Exceptions\Gw2ApiException;
use App\Services\ArenaNetServices\Gw2Validator;
use App\Services\ArenaNetServices\Gw2HttpClient;

class Gw2ItemService
{

    protected const API_VERSION = 'v2';
    protected const BASE_URL = 'https://api.guildwars2.com/' . self::API_VERSION;
    protected $validator;
    protected $httpClient;

    public function __construct(Gw2Validator $validator, Gw2HttpClient $httpClient)
    {
        $this->validator = $validator;
        $this->httpClient = $httpClient;
    }

    public function getAllFinishers() 
    {
        return $this->httpClient->get(self::BASE_URL."/finisher");
    }

    public function getFinisher(int $id) 
    {
        $this->validator->validateId($id);
        return $this->httpClient->get(self::BASE_URL."/finisher/{$id}");
    }

    public function getFinishers(array $ids)
    {
        $this->validator->validateIds($ids);
        return $this->httpClient->get(self::BASE_URL."/finisher", [ "ids" => implode(',', $ids)]);
    }

    public function getItem(int $id)
    {
        $this->validator->validateId($id);
        return $this->httpClient->get(self::BASE_URL."/items/{$id}");
    }

    public function getItems(array $ids)
    {
        $this->validator->validateIds($ids);
        return $this->httpClient->get(self::BASE_URL."/items", [ "ids" => implode(',', $ids)]);
    }

    public function getAllItems()
    {
        return $this->httpClient->get(self::BASE_URL."/items");
    }

    public function getItemStats(int $id)
    {   
        $this->validator->validateId($id);
        return $this->httpClient->get(self::BASE_URL."/itemstats/{$id}");
    }

    public function getItemsStats(array $ids)
    {
        $this->validator->validateIds($ids);
        return $this->httpClient->get(self::BASE_URL."/itemstats", ["ids" => implode(',', $ids)]);
    }

    public function getAllItemStats()
    {
        return $this->httpClient->get(self::BASE_URL."/itemstats");
    }

    public function getMaterialCategory(int $id)
    {
        $this->validator->validateId($id);
        return $this->httpClient->get(self::BASE_URL."/materials/{$id}");
    }

    public function getAllMaterialCategories()
    {
        return $this->httpClient->get(self::BASE_URL."/materials");
    }

    public function getPvpAmulet(int $id)
    {
        $this->validator->validateId($id);
        return $this->httpClient->get(self::BASE_URL."/pvp/amulets/{$id}");
    }

    public function getAllPvpAmulets(int $page = 0, int $pageSize = 0)
    {
        $params = array_filter([
            'page' => $page > 0 ? $page : null,
            'page_size' => $pageSize > 0 ? $pageSize : null,
        ]);

        return $this->httpClient->get(self::BASE_URL."/pvp/amulets", $params);
    }

    public function getRecipe(int $id)
    {
        $this->validator->validateId($id);
        return $this->httpClient->get(self::BASE_URL."/recipes/{$id}");
    }

    public function getAllRecipes()
    {
        return $this->httpClient->get(self::BASE_URL."/recipes");
    }

    public function getRecipeSearch(int $inputId = 0, int $outputId = 0)
    {
        $params = array_filter([
            'input' => $inputId > 0 ? $inputId : null,
            'output' => $outputId > 0 ? $outputId : null
        ]);

        if (!empty($params)) {
            return $this->httpClient->get(self::BASE_URL."/recipes/search", $params);
        }

        throw new Gw2ApiException('Error: No inputId or outputId informed on getRecipeSearch endpoint', 000);
    }

    public function getSkin(int $id)
    {
        $this->validator->validateId($id);
        return $this->httpClient->get(self::BASE_URL."/skins/{$id}");
    }

    public function getAllSkins()
    {
        return $this->httpClient->get(self::BASE_URL."/skins");
    }

}