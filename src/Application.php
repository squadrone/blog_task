<?php

namespace Project;

use Project\Services\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\VarDumper\Cloner\Data;

class Application
{
    private static object $instance;
    private string $environment = 'prod';
    private RouteCollection $routeCollection;
    private UrlGenerator $urlGenerator;
    private Database $databaseService;

    const CACHE_DIR = __DIR__.'/../cache/';
    const CONFIG_DIR = __DIR__.'/../config/';
    const TEMPLATE_DIR = __DIR__.'/Views/';

    private function __construct()
    {
        $this->routeCollection = new RouteCollection();
        $this->databaseService = Database::getInstance();
    }

    public static function getInstance(): Application {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getDatabase(): Database
    {
        return $this->databaseService;
    }

    public function handleRequest(): void
    {
        $context = new RequestContext();
        $request = Request::createFromGlobals();
        try
        {
            $context->fromRequest($request);
            $this->urlGenerator = new UrlGenerator($this->routeCollection, $context);
            $matcher = new UrlMatcher($this->routeCollection, $context);
            $parameters = $matcher->match($context->getPathInfo());
        }
        catch (ResourceNotFoundException $e)
        {
            $parameters = $this->getPageNotFoundControllerParameters();
        }
        catch (MethodNotAllowedException $e)
        {
            $parameters = $this->getMethodNotAllowedControllerParameters();
        }
        $this->callControllerMethod($request, $parameters);
    }

    private function callControllerMethod(Request $request, array $parameters): void {
        $controllerClassPath = "\\Project\\Controllers\\{$parameters['controller']}";
        $controller = new $controllerClassPath;
        $method = $parameters['method'];
        unset($parameters['controller']);
        unset($parameters['method']);
        unset($parameters['_route']);
        $parameters['request'] = $request;
        call_user_func_array([$controller, $method], $parameters);
    }

    public function addRoute(string $name, string $path, array|string $methods, array $defaults = [], array $requirements = []): Route
    {
        $route = new Route($path, $defaults, $requirements, [], '', [], $methods, null);
        $this->routeCollection->add($name, $route);
        return $route;
    }

    public function generateURL(string $routeName, array $parameters = []): string
    {
        return $this->urlGenerator->generate($routeName, $parameters);
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
        $this->initializeConfig();
    }

    private function initializeConfig(): void
    {
        include_once self::CONFIG_DIR.$this->environment.'/init.php';
        include_once self::CONFIG_DIR.'routes.php';
    }

    private function getPageNotFoundControllerParameters(): array
    {
        return [
            'controller' => 'ErrorController',
            'method' => 'pageNotFound',
            'message' => 'The page you are looking for not available!'
        ];
    }

    private function getMethodNotAllowedControllerParameters(): array
    {
        return [
            'controller' => 'ErrorController',
            'method' => 'notAllowed',
            'message' => 'The page you are looking is not accessible!'
        ];
    }
}