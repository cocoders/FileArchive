<?php

namespace Cocoders\Archive\InMemoryArchive;

use Cocoders\Archive\Archive;
use Cocoders\Archive\ArchiveFile;

class InMemoryArchive implements Archive
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ArchiveFile[]
     */
    private $files;

    /**
     * @var bool
     */
    private $uploaded = false;

    /**
     * @param string $name
     */
    public function __construct($name, array $archiveFiles)
    {
        $this->name = $name;
        $this->files = $archiveFiles;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function isUploaded()
    {
        return $this->uploaded;
    }

    public function upload()
    {
        $this->uploaded = true;
    }
}
