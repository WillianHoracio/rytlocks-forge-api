<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncRecord extends Model
{
    protected $fillable = [
        'id',
        'type',
        'is_synced',
        'created_at',
        'updated_at'
    ];
    protected $connection = 'game-pgsql';

    public const ITEM = 'item';

}
