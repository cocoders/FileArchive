<?php

namespace Cocoders\Upload\UploadProvider;


interface UploadProvider
{
    /**
     * @param array $paths
     * @return void
     */
    public function upload($paths);
}
