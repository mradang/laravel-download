<?php

namespace mradang\LaravelDownload;

use Illuminate\Support\ServiceProvider;
use mradang\LaravelDownload\Controllers\DownloadController;

class LaravelDownloadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->router->get('api/download/{key}', [DownloadController::class, 'download'])
            ->where('key', '^\w{32}$');
    }
}
