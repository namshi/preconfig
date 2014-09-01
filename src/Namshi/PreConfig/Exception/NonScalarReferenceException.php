<?php

namespace Namshi\PreConfig\Exception;

/**
 * Class NonScalarReferenceException
 * @package Namshi\PreConfig\Exception
 */
class NonScalarReferenceException extends \Exception
{
    const MESSAGE = 'Could not resolve references';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
} 