<?php
namespace App\Services\ArenaNetIntegrator;

use Illuminate\Support\Facades\Log;

class Gw2ItemSyncLogging
{
    public function writeInfo(string $message, array $context = []) {
        Log::channel('gw2sync')->info($message, $context);
    }

    public function writeError(string $message, array $context = []) {
        Log::channel('gw2sync')->error($message, $context);
    }

    public function writeDebug(string $message, array $context = []) {
        Log::channel('gw2sync')->debug($message, $context);
    }

    public function writeHeader(string $title)
    {
        $line = str_repeat('-', 60);
        $formatted = "\n$line\n>>> $title <<<\n$line";
        Log::channel('gw2sync')->info($formatted);
    }
}