<?php

namespace mradang\LaravelDownload\Test;

use mradang\LaravelDownload\LaravelDownloadServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected $app;

    /**
     * Load package service provider.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [LaravelDownloadServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $this->app = $app;
    }

    protected function setUp(): void
    {
        parent::setUp();
    }
}
