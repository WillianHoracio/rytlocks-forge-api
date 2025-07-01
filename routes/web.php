<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;


Route::middleware('api')->group(function () {
    Route::get('/gw2/item', [ItemController::class, 'getAllItens']);
    Route::get('/gw2/item/{id}', [ItemController::class, 'show']);
});


/*
tabela item:

    id (number)
    chat_link (string)
    name (string)
    icon (string nullable)
    description (string nullable)
    type (string) [
        Armor
        Back
        Bag
        Consumable
        Container
        CraftingMaterial
        Gathering
        Gizmo
        JadeTechModule
        Key
        MiniPet
        PowerCore
        Relic
        Tool
        Trait
        Trinket
        Trophy
        UpgradeComponent
        Weapon
    ]
    rarity (string) [
        Junk
        Basic
        Fine
        Masterwork
        Rare
        Exotic
        Ascended
        Legendary
    ]
    dafault_skin (number)
    flags (array of strings) [
        AccountBindOnUse
        AccountBound
        Attuned
        BulkConsume
        DeleteWarning
        HideSuffix
        Infused
        MonsterOnly
        NoMysticForge
        NoSalvage
        NoSell
        NotUpgradeable
        NoUnderwater
        SoulbindOnAcquire
        SoulBindOnUse
        Tonic
        Unique
    ]
    game_types (array of strings) [
        Activity
        Dungeon
        Pve
        Pvp
        PvpLobby
        Wvw
    ]
    restrictions (array of strings) [
        Asura
        Charr
        Female
        Human
        Norn
        Revenant
        Sylvari
        Elementalist
        Engineer
        Guardian
        Mesmer
        Necromancer
        Ranger
        Thief
        Warrior
    ]


*/