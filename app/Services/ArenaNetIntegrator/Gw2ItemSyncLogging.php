<?php
namespace App\Services\ArenaNetIntegrator;

use Illuminate\Support\Facades\Log;

class Gw2ItemSyncLogging
{
    public function writeInfo(string $message, array $context = []) {
        Log::channel('gw2sync')->info($message, $context);
        echo $message . PHP_EOL;
    }

    public function writeError(string $message, array $context = []) {
        Log::channel('gw2sync')->error($message, $context);
        echo $message . PHP_EOL;
    }

    public function writeDebug(string $message, array $context = []) {
        Log::channel('gw2sync')->debug($message, $context);
        echo $message . PHP_EOL;
    }

    public function writeHeader(string $title)
    {
        $line = str_repeat('-', 60);
        $formatted = "\n$line\n>>> $title <<<\n$line";
        $this->writeInfo($formatted);
    }
 
    public function writeSubHeader(string $title)
    {
        $line = str_repeat('=', 40);
        $formatted = "\n$line\n>> $title <<\n$line\n";
        $this->writeInfo($formatted);
    }

    public function writeItem(string $message)
    {
        $formatted = "  -> [{$message}]";
        $this->writeInfo($formatted);
    }

    public function writeStartingChunk($actualChunk, $totalChunk)
    {
        $formatted = "Starting Chunk {$actualChunk} of {$totalChunk}";
        $this->writeSubHeader($formatted);
    }
}