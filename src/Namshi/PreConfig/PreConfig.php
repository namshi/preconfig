<?php

namespace Namshi\PreConfig;

use Namshi\PreConfig\Exception\CircularReferenceException;
use Namshi\PreConfig\Exception\NonScalarReferenceException;

/**
 * Class PreConfig
 *
 * @package Namshi\PreConfig
 */
class PreConfig
{
    const KEY_SEPARATOR     = '.';
    const MAX_ALLOWED_DEPTH = 10;

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
        $this->depth = 0;

        return $this->_get($key, $params, $fallbackValue);
    }

    protected function resolveReferences($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        preg_match_all('/{{\s*([\w\.]+)\s*}}/', $value, $references, PREG_SET_ORDER);

        if ( ! $references) {
            return $value;
        } elseif (count($references) === 1) {
            return $this->_get(trim($references[0][1]));
        }

        $placeholderToValue = [];

        foreach ($references as $reference) {
            $placeholderToValue[$reference[0]] = $refVal = $this->_get(trim($reference[1]));

            if (is_array($refVal)) {
                throw new NonScalarReferenceException();
            }
        }

        return strtr($value, $placeholderToValue);
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
            $splitKey = explode(self::KEY_SEPARATOR, $key, 2);

            if (count($splitKey) > 1) {
                return $this->getValueByKey($configs[$splitKey[0]], $splitKey[1], $params);
            }
        }

        return $fallbackValue;
    }

    protected function _get($key = '', $params = [], $fallbackValue = null)
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
}
