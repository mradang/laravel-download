<?php

namespace mradang\LaravelDownload\Controllers;

use Illuminate\Http\Request;
use mradang\LaravelDownload\Services\DownloadService;

class DownloadController extends Controller
{
    public function download(Request $request)
    {
        $validatedData = $this->validate($request, [
            'key' => 'required|string|size:32',
        ]);
        return DownloadService::download($validatedData['key']);
    }
}
