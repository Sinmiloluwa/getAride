<?php

namespace App\Services\Paystack;

use Illuminate\Http\Client\RequestException;

trait HttpTrait
{
    public array $body = [];

    protected  $response;

    public function add($key, $value): static
    {
        $this->body[$key] = $value;
        return $this;
    }

    /**
     * @param $url
     * @param array $params
     * @throws RequestException
     */
    protected function get($url, array $params=[]): void
    {

        $body = array_merge($this->body, $params);
        $this->response = $this->client->retry(3, 100)->get($this->baseUrl . $url, $body)->throw()->json();
    }

    /**
     * @param $url
     * @throws RequestException
     */
    protected function post($url): void
    {
        $this->response = $this->client->post($this->baseUrl . $url, $this->body)->throw()->json();
    }
}
