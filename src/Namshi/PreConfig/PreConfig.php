<?php

namespace Namshi\PreConfig;

use Symfony\Component\Yaml\Yaml;

class PreConfig
{
    const KEY_SEPARATOR = '.';

    protected $configs = [];

    public function __construct(array $configs = [])
    {
        $this->configs = $configs;
    }

    public function get($key = '', $fallbackValue = null)
    {
        if (!$key) {
            return $this->configs;
        }

        $value = $this->getValueByKey($this->configs, $key, $fallbackValue);

        return $value;
    }

    protected function getValueByKey(array $configs, $key, $fallbackValue = null)
    {
        if (array_key_exists($key, $configs)) {
            return $configs[$key];
        }

        if (strpos($key, self::KEY_SEPARATOR)) {
            $splitKey = explode(self::KEY_SEPARATOR, $key);

            if (count($splitKey) > 1) {

                $nextKey = str_replace($splitKey[0] . '.', '', $key);

                return $this->getValueByKey($configs[$splitKey[0]], $nextKey);
            }
        }

        return $fallbackValue;
    }
}
