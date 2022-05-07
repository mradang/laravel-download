<?php

namespace mradang\LaravelDownload\Controllers;

use Illuminate\Http\Request;
use mradang\LaravelDownload\Services\DownloadService;

class DownloadController extends Controller
{
    public function download(Request $request, string $key = '')
    {
        return DownloadService::download($request->input('key', $key));
    }
}
