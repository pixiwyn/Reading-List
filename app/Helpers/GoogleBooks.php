<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class GoogleBooks {
    /**
     * @var string
     */
    protected $baseUri = 'https://www.googleapis.com/books/v1/';

    /**
     * @var integer (Number of results to retrieve per batch, between 1 and 40)
     */
    protected $batchSize = 25;

    /**
     * @var Client
     */
    protected $http;

    /**
     * @var string API key
     */
    protected $key;

    /**
     * @var string 2 letter ISO 639 country code.
     */
    protected $country;

    /**
     * @var string maxResults
     */
    public $maxResults;

    public function __construct($options = [])
    {
        $this->http = new Client([
            'base_uri' => $this->baseUri,
            'handler' => isset($options['handler']) ? $options['handler'] : null,
        ]);

        $this->key = isset($options['key']) ? $options['key'] : null;
        $this->country = isset($options['country']) ? $options['country'] : null;

        $this->batchSize = isset($options['batchSize']) ? $options['batchSize'] : 25;

        $this->maxResults = isset($options['maxResults']) ? $options['maxResults'] : null;
    }

    public function raw($endpoint, $params = [], $method='GET')
    {
        if (!is_null($this->key)) {
            $params['key'] = $this->key;
        }
        if (!is_null($this->country)) {
            $params['country'] = $this->country;
        }

        if (!is_null($this->maxResults)) {
            $params['maxResults'] = $this->maxResults;
        }

        try {
            $response = $this->http->request($method, $endpoint, [
                'query' => $params,
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // 400 level errors
            if ($e->getResponse()->getStatusCode() == 403) {
                $json = json_decode($e->getResponse()->getBody());

                $domain = $json->error->errors[0]->domain;
                $reason = $json->error->errors[0]->reason;
                $message = $json->error->errors[0]->message;

                if ($domain == 'usageLimits') {
                    throw new Exceptions\UsageLimitExceeded($message, $reason);
                }
            }

            throw $e;

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // networking error (connection timeout, DNS errors, etc.)

            // TODO: sleep and retry

            throw $e;
        }

        return json_decode($response->getBody(), true);
    }
}
