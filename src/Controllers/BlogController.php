<?php

namespace Project\Controllers;

use Project\Application;
use Project\Services\BaseController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends BaseController
{
    public function overview(Request $request, int $page = 1): void
    {
        $app = Application::getInstance();
        $databaseConnection = $app->getDatabase()->connect(DATABASE_DSN);
        $homeURL = $app->generateURL('home');
        echo $this->view('blog.overview.html.twig', ['homeURL' => 'overview']);
    }

    public function newArticle(Request $request): void
    {
        echo 'New Blog Entry';
    }

    public function articleDetails(Request $request, int $id): void
    {
        echo "Blog Entry {$id}";
    }

    public function imprint(Request $request): void
    {
        echo 'Imprint';
    }
}