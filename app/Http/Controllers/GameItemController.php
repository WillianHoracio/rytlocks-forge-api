<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\ArenaNetServices\Gw2ItemService;

class GameItemController extends Controller
{
    public function index() 
    {
        $gw2Service = new Gw2ItemService();

        $legendaryArmory = $gw2Service->getLegendaryArmory();
        
        return response()->json(
            $legendaryArmory->json()
        );
    }

    public function getAllItens()
    {
        $gw2Service = new Gw2ItemService();

        return response()->json(
            $gw2Service->getAllItems()->json()
        );
    }

    public function show($id) 
    {
        $gw2Service = new Gw2ItemService();

        return response()->json(
            $gw2Service->getItem($id)->json()
        );
    }

    public function craftRecipe($id) 
    {
        $gw2Service = new Gw2ItemService();

        return response()->json(
            $gw2Service->getItemRecipe($id)->json()
        );
    }
}
