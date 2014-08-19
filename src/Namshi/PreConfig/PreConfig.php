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

    protected function resolveReferences($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        preg_match('/{{\s*[\w\.]+\s*}}/', $value, $references);

        if (!$references) {
            return $value;
        }

        if (count($references) === 1) {
            $reference = preg_replace('/{{(.*)}}/i', '$1', $references[0]);

            if (!is_string($reference)) {
                return $this->get(trim($reference));
            }
        }

        return preg_replace("/{{\s*{{(.*)}}+\s*}}/i", '$1', $this->get(trim(preg_replace('/{{(.*)}}/i', '$1', $value))));
    }

    protected function resolveParameters($value, $params)
    {

    }

    protected function getValueByKey(array $configs, $key, $fallbackValue = null)
    {
        if (array_key_exists($key, $configs)) {

            return $this->resolveReferences($configs[$key]);
        }

        if (strpos($key, self::KEY_SEPARATOR)) {
            $splitKey = explode(self::KEY_SEPARATOR, $key);

            if (count($splitKey) > 1) {

                $nextKey = str_replace($splitKey[0] . self::KEY_SEPARATOR, '', $key);

                return $this->getValueByKey($configs[$splitKey[0]], $nextKey);
            }
        }

        return $fallbackValue;
    }
}
