<?php

namespace Steam\Requests;

class SaleHistory extends \Steam\Engine\Request implements \Steam\Interfaces\Request
{
    const URL = 'https://steamcommunity.com/market/listings/%s/%s';

    private $appId;
    private $itemName = '';
    private $method = 'GET';

    public function __construct($appId, $options = [])
    {
        $this->appId = $appId;
        $this->setOptions($options);
    }

    public function getUrl()
    {
        return sprintf(self::URL, $this->appId, $this->itemName);
    }

    public function call($options = [])
    {
        return $this->setOptions($options)->steamHttpRequest();
    }

    public function getRequestMethod()
    {
        return $this->method;
    }

    private function setOptions($options)
    {
        $this->itemName = isset($options['itemName']) ? $options['itemName'] : $this->itemName;

        return $this;
    }
}
