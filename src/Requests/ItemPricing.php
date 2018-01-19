<?php

namespace Steam\Requests;

class ItemPricing extends \Steam\Engine\Request implements \Steam\Interfaces\Request
{
    const URL = 'http://steamcommunity.com/market/priceoverview/?appid=%s&currency=%s&market_hash_name=%s';

    private $appId;
    private $currency = 1;
    private $itemName = '';
    private $method = 'GET';

    public function __construct($appId, $options = [])
    {
        $this->appId = $appId;
        $this->setOptions($options);
    }

    public function getUrl()
    {
        return sprintf(self::URL, $this->appId, $this->currency, $this->itemName);
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
        $this->currency = isset($options['currency']) ? $options['currency'] : $this->currency;
        $this->itemName = isset($options['itemName']) ? $options['itemName'] : $this->itemName;

        return $this;
    }
}
