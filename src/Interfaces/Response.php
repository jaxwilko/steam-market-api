<?php

namespace Steam\Interfaces;

interface Response
{
    public function __construct($response);

    public function raw();
}
