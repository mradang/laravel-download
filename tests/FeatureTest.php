<?php

namespace mradang\LaravelDownload\Test;

use Illuminate\Http\UploadedFile;
use mradang\LaravelDownload\Services\DownloadService;

class FeatureTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @covers DownloadController::download
     */
    public function testBasicFeatures()
    {
        $res = $this->json('GET', 'api/download/abc');
        $res->assertStatus(404);

        $res = $this->json('GET', 'api/download/12345678901234567890123456789012');
        $res->assertStatus(404);

        $fakeImage = UploadedFile::fake()->image('image2.jpg');
        $pathname = $fakeImage->getPathname();
        $this->assertFileExists($pathname);
        $ret = DownloadService::add($pathname, 'abc.jpg');

        $this->assertNotEmpty(config('app.url'));
        $this->assertStringStartsWith(config('app.url') . '/api/download/', $ret['url']);

        $res = $this->json('GET', $ret['url']);
        $res->assertOk();
        $res->assertHeader('content-length', $fakeImage->getSize());
        $this->assertStringStartsWith('attachment', $res->headers->get('content-disposition'));
        $this->assertStringEndsWith('abc.jpg', $res->headers->get('content-disposition'));
    }
}
