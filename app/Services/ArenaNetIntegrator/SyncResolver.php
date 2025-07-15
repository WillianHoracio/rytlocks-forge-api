<?php
namespace App\Services\ArenaNetIntegrator;

use App\Models\SyncRecord;

class SyncResolver
{
    public function getUnsyncedIds(array $ids, string $type) : array
    {
        return array_diff($ids, $this->getSyncedIds($type));
    }

    public function getSyncedIds(string $type) : array
    {
        return SyncRecord::where('type', $type)
            ->where('is_synced', true)
            ->pluck('id')
            ->toArray();
    }
}