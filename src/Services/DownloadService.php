<?php

namespace mradang\LaravelDownload\Services;

use Illuminate\Support\Facades\Cache;

class DownloadService
{
    public static function add(
        string $pathname,
        string $filename,
        int $ttl = 60,
        bool $deleteFileAfterSend = true
    ) {
        $pathname = realpath($pathname);
        $cache = compact('pathname', 'filename', 'deleteFileAfterSend');
        $key = md5($pathname);
        Cache::put($key, $cache, $ttl);

        return [
            'key' => $key,
            'name' => $filename,
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
            return response()
                ->download($cache['pathname'], $cache['filename'])
                ->deleteFileAfterSend($cache['deleteFileAfterSend']);
        } else {
            abort(404);
        }
    }
}
