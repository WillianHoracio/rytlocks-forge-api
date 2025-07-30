<?php

namespace App\Services\ArenaNetIntegrator\Items;

class SyncValidator
{
    public function validateChunk($chunk)
    {
        if(empty($chunk)) {
            throw new \Exception("The chunk sended is empty");
        }
    }

    public function validateItems($items)
    {
        if(empty($items)) {
            throw new \Exception("The items sended is empty");
        }
    }
}
