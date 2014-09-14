<?php

namespace Cocoders\Upload\UploadedArchive;

use Cocoders\Archive\Archive;
use Cocoders\Upload\UploadProvider\UploadProvider;

interface UploadedArchiveFactory
{
    /**
     * @param Archive $archive
     * @param UploadProvider[] $providers
     * @return UploadedArchive
     */
    public function create(Archive $archive, array $providers);
} 