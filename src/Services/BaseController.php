<?php

namespace Project\Services;

use Project\Application;

class BaseController
{
    private Application $application;

    public function __construct()
    {
        $this->application = Application::getInstance();
    }
}