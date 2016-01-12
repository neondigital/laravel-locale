<?php

namespace Neondigital\LaravelLocale;

use View;

class ViewFinder implements ViewFinderInterface
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function find($view, $countryCode, $languageCode)
    {
        $basePath = $this->app->basePath() . '/resources/views/';
        $viewPath = str_replace($basePath, '', $view->getPath());

        if (!$viewPath) {
            return;
        }

        $viewExt = null;

        foreach (View::getExtensions() as $ext => $name) {
            if (ends_with($viewPath, $ext)) {
                $viewExt = $ext;
            }
        }

        if (!$viewExt) {
            throw new \Exception('Missing view extension for ' . $viewPath);
        }

        $viewPathMinusExt = str_replace(array_keys(View::getExtensions()), '', $viewPath);

        // Try find a locale view!

        $viewPathOptions = [
            $basePath . $countryCode . '/' . $languageCode . '/' . $viewPath,
            $basePath . $countryCode . '/' . $viewPathMinusExt . $languageCode . '.' . $viewExt,
            $basePath . $countryCode . '/' . $viewPath,
            $basePath . $viewPathMinusExt . $countryCode . '.' . $languageCode . '.' . $viewExt,
            $basePath . $viewPathMinusExt . $countryCode . '.' . $viewExt,
            $basePath . $viewPathMinusExt . $languageCode . '.' . $viewExt,
        ];

        foreach ($viewPathOptions as $path) {
            if (file_exists($path)) {
                $view->setPath($path);
                return;
            }
        }
    }
}
