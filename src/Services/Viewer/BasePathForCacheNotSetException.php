<?php

namespace Project\Services\Viewer;

class BasePathForCacheNotSetException extends \Exception
{
    const EXCEPTION_CODE = -2;

    public function __construct()
    {
        parent::__construct('BasePathForCache parameter must be set before calling view method.', self::EXCEPTION_CODE);
    }
}