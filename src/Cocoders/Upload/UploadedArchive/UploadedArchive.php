<?php

namespace Cocoders\Upload\UploadedArchive;

use Cocoders\Archive\Archive;
use Cocoders\Upload\UploadProvider\UploadProvider;

interface UploadedArchive extends Archive
{
    /**
     * @return UploadProvider[]
     */
    public function getProviders();
}
