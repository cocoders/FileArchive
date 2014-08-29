<?php

namespace Cocoders\Archive;

class ArchiveFile
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }
}
