<?php

namespace Steam\Responses;

class ItemPricing implements \Steam\Interfaces\Response
{
    private $raw;
    private $data;

    public function __construct($response)
    {
        $this->raw = $response;
        $this->data = $this->decodeResponse($response);
    }

    public function response()
    {
        return $this->data;
    }

    public function raw()
    {
        return $this->raw;
    }

    private function decodeResponse($response)
    {
        return json_decode($response);
    }
}
