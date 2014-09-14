<?php

namespace Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive;

use Cocoders\Archive\Archive;
use Cocoders\Upload\UploadedArchive\UploadedArchive;
use Cocoders\Upload\UploadedArchive\UploadedArchiveFactory;
use Cocoders\Upload\UploadProvider\UploadProvider;

class InMemoryUploadedArchiveFactory implements UploadedArchiveFactory
{
    /**
     * @param Archive $archive
     * @param UploadProvider[] $providers
     * @return UploadedArchive
     */
    public function create(Archive $archive, array $providers)
    {
        return new InMemoryUploadedArchive($archive, $providers);
    }
}
