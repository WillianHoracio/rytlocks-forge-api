<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArenaNetIntegrator\Items\SyncService;

class SyncGw2Items extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-gw2-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all gw2 items and save in an local storage';

    /**
     * Execute the console command.
     */
    public function handle(SyncService $service)
    {
        $retorno = $service->syncItems();
        $this->info(print_r($retorno, true));
        return $service->syncItems();
    }
}
