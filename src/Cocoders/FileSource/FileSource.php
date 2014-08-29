<?php

namespace Cocoders\FileSource;


interface FileSource
{
    /**
     * @param $path
     * @return File[]
     */
    public function getFiles($path);
}
