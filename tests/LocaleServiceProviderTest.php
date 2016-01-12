<?php

namespace Neondigital\LaravelLocale\Tests;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Mockery;
use Neondigital\LaravelLocale\LocaleServiceProvider;

class LocaleServiceProviderTest extends TestCase
{
    /**
     * @var Mockery\Mock
     */
    protected $applicationMock;

    /**
     * @var ServiceProvider
     */
    protected $serviceProvider;

    protected function setUp()
    {
        $this->setUpMocks();

        $this->serviceProvider = new LocaleServiceProvider($this->applicationMock);

        parent::setUp();
    }

    protected function setUpMocks()
    {
        $this->applicationMock = Mockery::mock(Application::class);
    }

    /**
     * @test
     */
    public function testItCanBeConstructed()
    {
        $this->assertInstanceOf(ServiceProvider::class, $this->serviceProvider);
    }

    /**
     * @test
     */
    public function testRegisterMethod()
    {
        $this->applicationMock->shouldReceive('singleton')->once()->andReturn([]);
        $this->applicationMock->shouldReceive('bind')->once()->andReturn([]);

        $this->serviceProvider->register();
    }

    /**
     * @test
     */
    public function testItPerformsABootMethod()
    {
        $this->applicationMock->shouldReceive('version')->once()->andReturn('5.2.6');
        $this->applicationMock->shouldReceive('make')->once()->andReturn('fake_config_path');

        $dispatcherMock = Mockery::mock(Dispatcher::class);
        $dispatcherMock->shouldReceive('listen')->once();

        $this->serviceProvider->boot($dispatcherMock);
    }
}
