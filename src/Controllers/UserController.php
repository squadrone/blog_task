<?php

namespace Project\Controllers;

use Project\Application;
use Project\Entities\User;
use Project\Services\BaseController;
use Project\Services\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class UserController extends BaseController
{
    private Application $application;

    public function __construct()
    {
        $this->application = Application::getInstance();
    }

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
        $app = Application::getInstance();
        $homeURL = $app->generateURL('home');
        echo $this->view('register.html.twig', ['homeURL' => $homeURL]);
    }

    public function registerVerify(Request $request): void
    {
        $post = $request->request->all();
        if (array_key_exists('username', $post) && array_key_exists('password', $post)) {
            if (!$this->checkUserAlreadyExists($post['username'])) {
                $app = Application::getInstance();
                dump($app->getDatabase()->connect(DATABASE_DSN));
                die;
                $user = new User();
                $user->setUsername($post['username']);
                $user->setPassword($this->hashPassword($post['password']));
                $user->save();
            }
        }
    }

    private function checkUserAlreadyExists($username): bool {
        $connection = $this->application->getDatabase()->getConnection();
        $stmt = $connection->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        if (is_array($user) && count($user))
        {
            return true;
        }
        return false;
    }

    private function hashPassword($rawPassword): string {
        return md5($rawPassword);
    }


}