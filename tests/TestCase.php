<?php

namespace Neondigital\LaravelLocale\Tests;

use PHPUnit_Framework_TestCase;
use Mockery;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    protected $viewPresenterRoot;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->viewPresenterRoot = realpath(__DIR__.'/../src');
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
