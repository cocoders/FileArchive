<?php

namespace Cocoders\FileSource;

class File
{
    public $path;

    public function __construct($path)
    {
        $this->path = $path;
    }
}
