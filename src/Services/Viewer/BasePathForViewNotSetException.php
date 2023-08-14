<?php

namespace Project\Services\Viewer;

class BasePathForViewNotSetException extends \Exception
{
    const EXCEPTION_CODE = -1;

    public function __construct()
    {
        parent::__construct('BasePathForView parameter must be set before calling view method.', self::EXCEPTION_CODE);
    }
}