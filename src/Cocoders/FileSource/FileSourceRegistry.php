<?php

namespace Cocoders\FileSource;

interface FileSourceRegistry
{
    /**
     * @param string $name
     * @return FileSource
     */
    public function get($name);

    /**
     * @param string $name
     * @param FileSource $fileSource
     * @return void
     */
    public function register($name, FileSource $fileSource);
}
