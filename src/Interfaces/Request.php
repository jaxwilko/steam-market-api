<?php

namespace Steam\Interfaces;

interface Request
{
    public function __construct($appId, $options);

    public function getUrl();

    public function getRequestMethod();
}
