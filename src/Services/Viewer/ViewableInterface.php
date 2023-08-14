<?php

namespace Project\Services\Viewer;

interface ViewableInterface
{
    public function view($relativePathForView);
}