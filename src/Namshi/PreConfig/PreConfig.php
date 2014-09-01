<?php

namespace Namshi\PreConfig;

use Namshi\PreConfig\Exception\CircularReferenceException;

/**
 * Class PreConfig
 *
 * @package Namshi\PreConfig
 */
class PreConfig
{
    const KEY_SEPARATOR     = '.';
    const MAX_ALLOWED_DEPTH = 100;

    /**
     * @var array
     */
    protected $configs = [];

    protected $depth;

    /**
     * Constructor
     *
     * @param array $configs
     */
    public function __construct(array $configs = [])
    {
        $this->configs  = $configs;
        $this->depth    = 0;
    }

    /**
     * Returns a configuration value, by key.
     *
     * @param string        $key
     * @param array         $params
     * @param null|mixed    $fallbackValue
     *
     * @return array|mixed|null
     */
    public function get($key = '', $params = [], $fallbackValue = null)
    {
        if (!$key) {
            return $this->configs;
        }

        $value = $this->getValueByKey($this->configs, $key, $params, $fallbackValue);

        if (is_string($value)) {
            $value = $this->resolveReferences($value);

            if ($params) {
                $value = $this->resolveParameters($value, $params);
            }
        }

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
        foreach ($params as $key => $param) {
            $value = str_replace(':' . $key, $param, $value);
        }

        return $value;
    }

    protected function getValueByKey(array $configs, $key, $params, $fallbackValue = null)
    {
        if (++$this->depth > self::MAX_ALLOWED_DEPTH) {
            throw new CircularReferenceException();
        }

        if (array_key_exists($key, $configs)) {
            return $this->resolveReferences($configs[$key]);
        }

        if (strpos($key, self::KEY_SEPARATOR)) {
            $splitKey = explode(self::KEY_SEPARATOR, $key);

            if (count($splitKey) > 1) {
                $nextKey = str_replace($splitKey[0] . self::KEY_SEPARATOR, '', $key);

                return $this->getValueByKey($configs[$splitKey[0]], $nextKey, $params);
            }
        }

        return $fallbackValue;
    }
}
