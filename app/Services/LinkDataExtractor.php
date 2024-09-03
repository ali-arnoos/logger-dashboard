<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

class LinkDataExtractor
{
    /* @param  url  $string */
    /* @param  headers  [] */
    /* @param  queryParameters  [] */
    public static function extract($url, $headers = [], $queryParameters = [])
    {
        $client = new Client();

        $options = [
            'headers' => $headers,
            'query' => $queryParameters,
        ];

        $data = [
            'headers' => $headers,
            'query_parameters' => $queryParameters,
            'content' => ''
        ];

        try {
            $response = $client->request('GET', $url, $options);

            $data['content'] = (string) $response->getBody(); 

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
