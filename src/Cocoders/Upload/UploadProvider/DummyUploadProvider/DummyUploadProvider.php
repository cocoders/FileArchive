<?php

namespace Cocoders\Upload\UploadProvider\DummyUploadProvider;

use Cocoders\Upload\UploadProvider\UploadProvider;

class DummyUploadProvider implements UploadProvider
{

    /**
     * @param array $paths
     * @return void
     */
    public function upload($name, $paths)
    {
    }
}
