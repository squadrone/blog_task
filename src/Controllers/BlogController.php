<?php

namespace Project\Controllers;

use Project\Services\BaseController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends BaseController
{
    public function overview(Request $request, int $page = 1): void
    {
        echo $this->view('blog.overview.html.twig', ['homeURL' => '/']);
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