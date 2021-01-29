<?php

declare(strict_types=1);

namespace App\Gateways;

use Illuminate\Support\Facades\Http;

trait MakeRequest
{
    public function makeRequest(string $method, string $requestUrl, array $data = []): object
    {
        $response = Http::asJson()->$method($requestUrl, $data);

        return $response->object();
    }
}
