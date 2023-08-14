<?php

namespace Project\Controllers;

use Project\Application;
use Project\Services\BaseController;
use Symfony\Component\HttpFoundation\Request;

class ErrorController extends BaseController
{
    public function pageNotFound(Request $request, $message): void
    {
        echo 'Page Not Found';
        dump($message);
    }

    public function notAllowed(Request $request, $message): void
    {
        echo 'Method Not Allowed';
        dump($message);
    }
}