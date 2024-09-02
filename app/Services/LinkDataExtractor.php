<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class LinkDataExtractor
{
    public static function extract($url)
    {
        $client = new Client();
        $data = [
            'headers' => [],
            'query_parameters' => [],
            'method' => 'GET',
            'content' => ''
        ];

        try {
            $response = $client->request('GET', $url);
            $data['headers'] = $response->getHeaders();
            $data['method'] = 'GET'; 
            $data['content'] = (string) $response->getBody(); 

            $parsedUrl = parse_url($url);
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $data['query_parameters']);
            }
        } catch (RequestException $e) {
            $data['headers'] = [];
            $data['method'] = 'GET';
            $data['content'] = ''; 
        }

        return $data;
    }
}
