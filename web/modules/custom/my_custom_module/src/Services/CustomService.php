<?php

namespace Drupal\my_custom_module\Services;

use GuzzleHttp\ClientInterface;

class CustomService {

    protected $httpClient;

    
    public function __construct(ClientInterface $http_client) {
        $this->httpClient = $http_client;
    }

    public function getApiData() {

        $response = $this->httpClient->get('https://reqres.in/api/users?page=1');
        return json_decode($response->getBody()->getContents(), TRUE);

    }
}
