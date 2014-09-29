<?php

namespace Cocoders\Upload\UploadedArchive;

use Cocoders\Archive\Archive;
use Cocoders\Upload\UploadProvider\UploadProvider;

interface UploadedArchive
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return UploadProvider[]
     */
    public function getProviders();
}
