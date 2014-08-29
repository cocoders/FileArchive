<?php

namespace Cocoders\Archive\InMemoryArchive;

use Cocoders\Archive\Archive;
use Cocoders\Archive\ArchiveFile;

class InMemoryArchive implements Archive
{
    /**
     * @var String
     */
    private $name;

    /**
     * @var ArchiveFile[]
     */
    private $files;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $archiveFile
     */
    public function addFile($archiveFile)
    {
        $this->files[] = $archiveFile;
    }
}
