<?php

namespace Namshi\PreConfig\Exception;

/**
 * Class CircularReferenceException
 * @package Namshi\PreConfig\Exception
 */
class CircularReferenceException extends \Exception
{
    const MESSAGE = 'Could not resolve parameters, circular reference detected';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
} 