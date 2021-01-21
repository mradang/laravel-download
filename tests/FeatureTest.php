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
        $res = $this->json('GET', 'api/download?key=abc');
        $this->assertSame(['key' => 'abc'], request()->all());
        $res->assertStatus(422);

        $res = $this->json('GET', 'api/download?key=12345678901234567890123456789012');
        $res->assertStatus(404);

        $fakeImage = UploadedFile::fake()->image('image2.jpg');
        $pathname = $fakeImage->getPathname();
        $this->assertFileExists($pathname);
        $ret = DownloadService::add($pathname, 'abc.jpg');

        $res = $this->json('GET', 'api/download?key='.$ret['key']);
        $res->assertOk();
        $res->assertHeader('content-length', $fakeImage->getSize());
        $this->assertStringStartsWith('attachment', $res->headers->get('content-disposition'));
        $this->assertStringEndsWith('abc.jpg', $res->headers->get('content-disposition'));
    }
}
