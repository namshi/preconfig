<?php

namespace Namshi\PreConfig;

use Symfony\Component\Yaml\Yaml;

class PreConfig
{
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

        $value = $this->getValueByPath($key, $fallbackValue);

        return $value;
    }

    protected function getValueByPath($path, $fallbackValue)
    {
        if (!array_key_exists($path, $this->configs)) {
            return $fallbackValue;
        }

        $value = $this->configs[$path];

        return empty($value) ? $fallbackValue : $value;

    }
}
