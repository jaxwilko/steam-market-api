<?php

namespace Steam\Responses;

use Steam\Engine\XmlStringStreamerAbstract;

class MarketList extends XmlStringStreamerAbstract implements \Steam\Interfaces\Response
{
    const CLASS_DELIMITER = 'market_listing_row market_recent_listing_row market_listing_searchresult';

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
        $data = json_decode($response);

        if (!$data) {
            return false;
        }

        $listings = [];

        $streamer = $this->loadString($data->results_html)->getStreamer([
            'captureDepth' => 2,
            'uniqueNode' => 'a',
            'expectGT' => true
        ]);

        while ($rawNode = $streamer->getNode()) {
            $item = $this->parseNode(simplexml_load_string($rawNode));

            if ($item) {
                $listings[] = $item;
            }
        }

        return $listings;
    }

    private function parseCondition($name)
    {
        if (substr(strtolower($name), 0, 9) == 'sticker |') {
            return 'sticker';
        }

        if (substr(strtolower($name), 0, 17) == 'sealed graffiti |') {
            return 'graffiti';
        }

        if (substr(strtolower($name), strlen($name) - 4) == 'case') {
            return 'case';
        }

        if (substr(strtolower($name), strlen($name) - 3) == 'key') {
            return 'key';
        }

        $elements = explode('(', strrev($name));

        if (count($elements) == 1) {
            return '';
        }

        return trim(strrev(str_replace(')', '', $elements[0])));
    }

    private function parseNode($node)
    {
        if ((string) $node->attributes()['class'] !== self::CLASS_DELIMITER) {
            return null;
        }

        return [
            'image' => (string) explode('/62fx62f', $node->img->attributes()['src'])[0],
            'name' => (string) $node->div[1]->span[0],
            'price' => (float) preg_replace('/[^\d\.]/', '', (string) $node->div[0]->div[1]->span->span[0]),
            'volume' => (int) preg_replace('/[^\d\.]/', '', (string) $node->div[0]->div[0]->span->span),
            'condition' => $this->parseCondition((string) $node->div[1]->span[0])
        ];
    }
}
