<?php
namespace Cocoders\FileSource;

interface FileSourceRegistry
{
    /**
     * @param $name
     * @return FileSource
     */
    public function get($name);

    public function register($name, FileSource $fileSource);
}
