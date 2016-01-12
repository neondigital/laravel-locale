<?php

namespace Neondigital\LaravelLocale\Tests\Listeners;

use Illuminate\Contracts\View\View;
use Mockery;
use Neondigital\LaravelLocale\Listeners\Composing;
use Neondigital\LaravelLocale\LocaleInterface;
use Neondigital\LaravelLocale\ViewFinderInterface;
use Neondigital\LaravelLocale\Tests\TestCase;

class ComposingTest extends TestCase
{
    /**
     * @var Mockery\Mock
     */
    protected $applicationMock;

    /**
     * @var Mockery\Mock
     */
    protected $viewMock;

    /**
     * @var Composing
     */
    protected $composingListener;

    protected function setUp()
    {
        $this->setUpMocks();

        $this->composingListener = new Composing($this->localeMock, $this->viewFinderMock);

        parent::setUp();
    }

    protected function setUpMocks()
    {
        $this->localeMock = Mockery::mock(LocaleInterface::class);

        $this->viewFinderMock = Mockery::mock(ViewFinderInterface::class);

        $this->viewMock = Mockery::mock(View::class);
        $this->viewMock->shouldReceive('getPath')->andReturn('');
    }

    /**
     * @test
     */
    public function testItCanBeConstructed()
    {
        $this->assertInstanceOf(Composing::class, $this->composingListener);
    }

    /**
     * @test
     */
    public function testItPerformsAHandleMethod()
    {
        $this->viewFinderMock->shouldReceive('find')->once()->andReturn('');

        $this->localeMock->shouldReceive('getCountryCode')->once()->andReturn('GB');
        $this->localeMock->shouldReceive('getLanguageCode')->once()->andReturn('en');

        $this->composingListener->handle($this->viewMock);
    }
}
