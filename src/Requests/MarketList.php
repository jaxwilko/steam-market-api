<?php

namespace Steam\Requests;

class MarketList extends \Steam\Engine\Request implements \Steam\Interfaces\Request
{
    const URL = 'http://steamcommunity.com/market/search/render/?start=%s&count=%s&sort_column=price&sort_dir=asc&appid=%s';

    private $appId;
    private $start = 0;
    private $count = 100;
    private $method = 'GET';

    public function __construct($appId, $options = [])
    {
        $this->appId = $appId;
        $this->setOptions($options);
    }

    public function getUrl()
    {
        return sprintf(self::URL, $this->start, $this->count, $this->appId);
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
        $this->start = isset($options['start']) ? $options['start'] : $this->start;
        $this->count = isset($options['count']) ? $options['count'] : $this->count;
        $this->method = isset($options['method']) ? $options['method'] : $this->method;

        return $this;
    }
}