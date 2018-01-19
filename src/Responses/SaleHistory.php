<?php

namespace Steam\Responses;

class SaleHistory implements \Steam\Interfaces\Response
{
    const DELIMITER_START = 'var line1=';
    const DELIMITER_END = ';';

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
        $dataString = substr($response, strpos($response, self::DELIMITER_START) + strlen(self::DELIMITER_START));
        $dataString = substr($dataString, 0, strpos($dataString, self::DELIMITER_END));

        $data = json_decode($dataString);

        if (!$data || empty($data)) {
            return [];
        }

        return array_map(function ($item) {
            $date = explode(' ', $item[0]);
            return [
                'sale_date' => date('Y-m-d', strtotime($date[1] . ' ' . $date[0] . ' ' . $date[2])),
                'sale_price' => (float) $item[1],
                'quantity' => (int) $item[2]
            ];
        }, $data);
    }
}
