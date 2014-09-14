<?php

namespace Cocoders\Upload\UploadProvider;


interface UploadProvider
{
    /**
     * @param string $name
     * @param array $paths
     * @return void
     */
    public function upload($name, $paths);
}
