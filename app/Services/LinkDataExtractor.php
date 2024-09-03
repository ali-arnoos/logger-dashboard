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

            $data['headers'] = json_encode($response->getHeaders());
            $data['content'] = (string) $response->getBody(); 

            $parsedUrl = parse_url($url);
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $data['query_parameters']);
            }

        } catch (ConnectException $e) {

            $data['content'] = json_encode([
                'error' => 'Connection error: Could not resolve host',
                'message' => $e->getMessage(),
            ]);
        } catch (RequestException $e) {
            
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : 'N/A';
            $errorMessage = $e->getMessage();
            
            $data['content'] = json_encode([
                'error' => 'Request error',
                'status_code' => $statusCode,
                'message' => $errorMessage,
            ]);
        }
        return $data;
    }
}
