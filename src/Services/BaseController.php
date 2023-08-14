<?php

namespace Project\Services;

use Project\Application;
use Project\Services\Viewer\Twig;

class BaseController
{
    use Twig;

    private Application $application;

    public function __construct()
    {
        $this->application = Application::getInstance();
        $this->setBasePathForView(Application::TEMPLATE_DIR);
        $this->setBasePathForCache($this->application->getEnvironment() == 'prod' ? Application::CACHE_DIR.'prod' : false);
    }
}