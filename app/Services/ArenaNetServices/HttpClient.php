<?php
namespace App\Services\ArenaNetServices;

use App\Exceptions\Gw2ApiException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HttpClient
{
    public function get(string $url, array $params = [])
    {
        return $this->execute(function() use ($url, $params) {
            $response = Http::retry(3, 100)->get($url, $params);
            return $this->handleResponse($response);
        });
    }

    public function handleResponse($response) 
    {
        if ($response->failed()) {
            throw new Gw2ApiException(
                'GW2 API Request failed: ' . $response->status(),
                $response->status()
            );
        }

        return $response->json();
    }

    public function http()
    {
        return Http::retry(3, 100);
    }

    public function execute(callable $callback)
    {
        try {
            return $callback();
        } catch (Gw2ApiException $e) {
            Log::error('GW2 API Exception (Items)', [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
            throw $e;
        }
    }
}