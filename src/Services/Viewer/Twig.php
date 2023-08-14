<?php

namespace Project\Services\Viewer;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\TemplateWrapper;
use Twig\TwigFunction;

trait Twig
{
    private string $basePathForView;
    private string|false $basePathForCache;
    private Environment $templateEnvironment;
    private TemplateWrapper $template;

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws BasePathForViewNotSetException
     * @throws BasePathForCacheNotSetException
     */
    public function view(string $relativePathForView, array $templateVariables = []): string
    {
        $this->checkBasePathForViewIsSet();
        $this->checkBasePathForCacheIsSet();
        $this->initializeEnvironmentIfRequires();
        $this->loadTemplate($relativePathForView);
        return $this->render($templateVariables);
    }

    /**
     * @throws BasePathForViewNotSetException
     */
    private function checkBasePathForViewIsSet(): void {
        if (empty($this->basePathForView)) {
            throw new BasePathForViewNotSetException();
        }
    }

    /**
     * @throws BasePathForCacheNotSetException
     */
    private function checkBasePathForCacheIsSet(): void {
        if ($this->basePathForCache !== false) {
            if (empty($this->basePathForCache)) {
                throw new BasePathForCacheNotSetException();
            }
        }
    }

    private function initializeEnvironmentIfRequires(): void
    {
        if (empty($this->templateEnvironment)) {
            $filesystemLoader = new FilesystemLoader($this->basePathForView);
            $this->templateEnvironment = new Environment($filesystemLoader, ['cache' => $this->basePathForCache]);
            $this->templateEnvironment->addFunction(new TwigFunction('asset', function ($asset) {
                return sprintf('../assets/%s', ltrim($asset, '/'));
            }));
            $this->templateEnvironment->addFunction(new TwigFunction('path', function ($routeName, $parameters = []) {
                return $this->application->generateURL($routeName, $parameters);
            }));
            $this->templateEnvironment->addFunction(new TwigFunction('is_granted', function ($roleName) {
                return true; // TODO
            }));
        }
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    private function loadTemplate($relativePathForView): void
    {
        $this->template = $this->templateEnvironment->load($relativePathForView);
    }

    private function render(array $templateVariables): string
    {
        return $this->template->render($templateVariables);
    }

    public function getBasePathForView(): string
    {
        return $this->basePathForView;
    }

    public function setBasePathForView(string $basePathForView): void
    {
        $this->basePathForView = $basePathForView;
    }

    public function getBasePathForCache(): string
    {
        return $this->basePathForCache;
    }

    public function setBasePathForCache(string|false $basePathForCache): void
    {
        $this->basePathForCache = $basePathForCache;
    }
}