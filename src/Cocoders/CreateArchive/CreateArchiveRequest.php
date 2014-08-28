<?php

namespace Cocoders\CreateArchive;

class CreateArchiveRequest
{
    public $name;
    public $fileSource;
    public $path;

    public function __construct($fileSource, $name, $path)
    {
        $this->fileSource = $fileSource;
        $this->name = $name;
        $this->path = $path;
    }
}
