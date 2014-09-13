<?php

namespace Cocoders\FileSource;

interface FileSource
{
    /**
     * @param string $path
     * @return File[]
     */
    public function getFiles($path);
}
