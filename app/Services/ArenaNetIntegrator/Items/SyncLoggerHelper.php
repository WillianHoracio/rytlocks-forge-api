<?php
namespace App\Services\ArenaNetIntegrator\Items;

use Illuminate\Support\Facades\Log;

class SyncLoggerHelper
{
    public function info(string $message, array $context = []) {
        Log::channel('gw2sync')->info($message, $context);
        echo $message . PHP_EOL;
    }

    public function error(string $message, array $context = []) {
        Log::channel('gw2sync')->error($message, $context);
        echo $message . PHP_EOL;
    }

    public function debug(string $message, array $context = []) {
        Log::channel('gw2sync')->debug($message, $context);
        echo $message . PHP_EOL;
    }

    public function header(string $title)
    {
        $line = str_repeat('-', 60);
        $formatted = "\n$line\n>>> $title <<<\n$line";
        $this->info($formatted);
    }
 
    public function subHeader(string $title)
    {
        $line = str_repeat('=', 40);
        $formatted = "\n$line\n>> $title <<\n$line\n";
        $this->info($formatted);
    }

    public function item(string $message)
    {
        $formatted = "  -> Item [{$message}] downloaded ";
        $this->info($formatted);
    }

    public function startingChunk($actualChunk, $totalChunk)
    {
        $this->subHeader("Starting Chunk {$actualChunk} of {$totalChunk}");
    }

    public function startingSync()
    {
        $this->header("STARTING ITEM SYNCHRONIZATION");
    }

    public function noItemsToSync()
    {
        $this->header("SYNCHRONIZATION COMPLETED. NO ITEMS WERE RETURNED FROM THE GAME SERVER!");
    }

    public function chunksPrepared(int $chunks)
    {
        $this->info($chunks . " chunks prepared. Starting download...");
    }

    public function chunkTryError(int $attempts, string $message)
    {
        $this->error("Error syncing chunk on attempt {$attempts}: {$message}");
    }

    public function chunkFatalError()
    {
        $this->error("Failed to sync chunk after all attempts.");
    }

}
