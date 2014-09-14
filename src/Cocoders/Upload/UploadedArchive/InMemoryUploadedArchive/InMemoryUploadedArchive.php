<?php

namespace Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive;

use Cocoders\Archive\Archive;
use Cocoders\Archive\ArchiveFile;
use Cocoders\Upload\UploadedArchive\UploadedArchive;
use Cocoders\Upload\UploadProvider\UploadProvider;

class InMemoryUploadedArchive implements UploadedArchive
{
    /**
     * @var \Cocoders\Archive\Archive
     */
    private $archive;
    /**
     * @var UploadProvider[]
     */
    private $providers;

    public function __construct(Archive $archive, array $providers)
    {
        $this->archive = $archive;
        $this->providers = $providers;
    }

    /**
     * @return UploadProvider[]
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->archive->getName();
    }

    /**
     * @return ArchiveFile[]
     */
    public function getFiles()
    {
        return $this->archive->getFiles();
    }
}
