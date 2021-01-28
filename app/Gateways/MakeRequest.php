<?php

declare(strict_types=1);


namespace App\Gateways;


use Illuminate\Support\Facades\Http;

trait MakeRequest
{
    public function makeRequest($method, $requestUrl, $queryParameters = []): object
    {
        if (method_exists($this, 'resolveAuthorization')) {
            $this->resolveAuthorization($queryParameters);
        }
        $response = Http::asJson()->$method($requestUrl, $queryParameters);

        return $response->object();
    }
}