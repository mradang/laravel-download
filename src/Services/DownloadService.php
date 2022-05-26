<?php

namespace mradang\LaravelDownload\Services;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use mradang\LaravelDownload\Jobs\DeleteTempFile;

class DownloadService
{
    public static function add(string $pathname, string $filename, $ttl = 3600)
    {
        $pathname = realpath($pathname);
        if (!Str::startsWith($pathname, storage_path())) {
            throw new Exception('Non storage paths are not supported');
        }

        $value = compact('pathname', 'filename');
        $key = md5($pathname . time());

        Cache::put($key, $value, $ttl);
        DeleteTempFile::dispatch($pathname)->delay($ttl);

        return [
            'name' => $filename,
            'url' => url('/api/download', $key),
        ];
    }

    public static function download($key)
    {
        $cache = Cache::get($key);
        if (
            $cache
            && array_key_exists('pathname', $cache)
            && array_key_exists('filename', $cache)
            && is_file($cache['pathname'])
        ) {
            return response()->download($cache['pathname'], $cache['filename']);
        } else {
            abort(404);
        }
    }
}
