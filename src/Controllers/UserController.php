<?php

namespace Project\Controllers;

use Project\Services\BaseController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends BaseController
{
    public function login(Request $request): void
    {
        echo 'User Controller Login method is working...';

        echo '<form method="POST"><input type="submit" name="test" value="submit" /></form>';
    }

    public function logout(Request $request): void
    {
        echo 'User Controller Logout method is working...';
    }

    public function loginVerify(Request $request): void
    {
        echo 'User Controller Verify Login method is working...';
    }

    public function register(Request $request): void
    {
        echo 'User Controller Register method is working...';

        echo '<form method="POST"><input type="submit" name="test" value="submit" /></form>';
    }

    public function registerVerify(Request $request): void
    {
        echo 'User Controller Verify Registration method is working...';
    }
}