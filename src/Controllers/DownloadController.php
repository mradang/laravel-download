<?php

namespace mradang\LaravelDownload\Controllers;

use Illuminate\Http\Request;
use mradang\LaravelDownload\Services\DownloadService;

class DownloadController extends Controller
{
    public function download(Request $request, string $key = '')
    {
        $this->validate($request, [
            'key' => 'nullable|string|size:32',
        ]);
        return DownloadService::download($request->input('key', $key));
    }
}
