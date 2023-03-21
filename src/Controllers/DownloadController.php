<?php

namespace mradang\LaravelDownload\Controllers;

use mradang\LaravelDownload\Services\DownloadService;

class DownloadController extends Controller
{
    public function download(string $key)
    {
        return DownloadService::download($key);
    }
}
