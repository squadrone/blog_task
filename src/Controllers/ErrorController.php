<?php

namespace Project\Controllers;

use Project\Application;
use Project\Services\BaseController;
use Symfony\Component\HttpFoundation\Request;

class ErrorController extends BaseController
{
    public function pageNotFound(Request $request, $message): void
    {
        $this->showTemplate($message);
    }

    public function notAllowed(Request $request, $message): void
    {
        $this->showTemplate($message);
    }

    private function showTemplate($message): void {
        $app = Application::getInstance();
        $homeURL = $app->generateURL('home');
        echo $this->view('404.html.twig', [
            'homeURL' => $homeURL,
            'message' => $message
        ]);
    }
}