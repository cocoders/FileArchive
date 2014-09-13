<?php

namespace Cocoders\FileSource;

class File
{
    /**
     * @var string
     */
    public $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }
}
