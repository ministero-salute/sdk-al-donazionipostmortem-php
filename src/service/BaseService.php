<?php
namespace AccessLayerMdS;

use GuzzleHttp\Client;

class BaseService
{
    public $client;

    public function initClient(string $baseUri) {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $baseUri,
            // You can set any number of default request options.
            'timeout'  => 5.0
        ]);
    }
}
