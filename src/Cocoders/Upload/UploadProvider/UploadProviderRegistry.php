<?php

namespace Cocoders\Upload\UploadProvider;

use Cocoders\Upload\UploadProvider\UploadProvider;

interface UploadProviderRegistry
{
    /**
     * @param string $name
     * @return UploadProvider
     */
    public function get($name);

    /**
     * @param string $name
     * @param UploadProvider $provider
     * @return void
     */
    public function register($name, UploadProvider $provider);
}
