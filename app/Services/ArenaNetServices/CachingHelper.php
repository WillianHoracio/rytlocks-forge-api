<?php
namespace App\Services\ArenaNetServices;

use Illuminate\Support\Facades\Cache;

class CachingHelper
{
    public function verifyItemsCached(array $ids)
    {
        $keys = array_map(fn($id) => "item_{$id}", $ids);
        $cachedRaw = Cache::many($keys);

        $cachedItems = [];
        $missingIds = [];

        foreach ($cachedRaw as $key => $item) {
            if ($item !== null) {
                $cachedItems[] = $item;
            } else {
                $id = (int) str_replace('item_', '', $key);
                $missingIds[] = $id;
            }
        }

        return [
            'cachedIds' => $cachedItems,
            'uncachedIds' => $missingIds,
        ];
    }
}
