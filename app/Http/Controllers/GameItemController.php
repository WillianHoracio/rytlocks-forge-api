<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\ArenaNetServices\ItemService;

class GameItemController extends Controller
{
    public function index() 
    {
        $gw2Service = new ItemService();
        //to do
        return response()->json();
    }

    public function getAllItens()
    {
        $gw2Service = new ItemService();

        return response()->json(
            $gw2Service->getAllItems()->json()
        );
    }

    public function show($id) 
    {
        $gw2Service = new ItemService();

        return response()->json(
            $gw2Service->getItem($id)->json()
        );
    }

    public function craftRecipe($id) 
    {
        $gw2Service = new ItemService();

        return response()->json(
            $gw2Service->getRecipe($id)->json()
        );
    }
}
