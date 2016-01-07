<?php

namespace Neondigital\LaravelLocale;

use View;

class ViewFinder
{
    protected $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function find($countryCode, $languageCode)
    {
        $basePath = base_path('resources/views/');
        $viewPath = str_replace($basePath, '', $this->view->getPath());

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
                $this->view->setPath($path);
                return;
            }
        }
    }
}
