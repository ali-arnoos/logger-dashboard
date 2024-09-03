<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

class LinkDataExtractor
{
    /* @param  url  $string */
    public static function extract($url)
    {
        $client = new Client();
        $data = [
            'headers' => [],
            'query_parameters' => [],
            'content' => ''
        ];

        try {
            $response = $client->request('GET', $url);

            $data['headers'] = $response->getHeaders();
            $data['content'] = (string) $response->getBody(); 

            $parsedUrl = parse_url($url);
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $data['query_parameters']);
            }

        } catch (ConnectException $e) {
            $data['content'] = "Connection error: Could not resolve host. Error: {$e->getMessage()}"; 
        } catch (RequestException $e) {

            $statusCode = $e->getResponse()->getStatusCode();
            $errorMessage = $e->getMessage();
            
            $data['content'] = "Status Code: {$statusCode}, Error: {$errorMessage}";
        }

        return $data;
    }
}
