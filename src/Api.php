<?php

namespace Steam;

use Psy\Exception\RuntimeException;

class Api
{
    const CLASS_PREFIX = '\\Steam\\Requests\\';

    private static $appId = false;

    public static function setAppId($appId)
    {
        self::$appId = $appId;
    }

    public static function request($type, $appId = false, array $options = [])
    {
        if (!$appId && !self::$appId) {
            throw new RuntimeException('Application ID not defined');
        }

        if ($appId) {
            self::$appId = $appId;
        }

        $class = self::CLASS_PREFIX . $type;

        if (!class_exists($class)) {
            throw new RuntimeException('Call to undefined request type');
        }

        return new $class(self::$appId, $options);
    }
}