<?php

namespace Cocoders\FileSource;

class FileSourceRegistry
{
    private $fileSources = [];

    public function register($name, FileSource $fileSource)
    {
        $this->fileSources[$name] = $fileSource;
    }

    public function get($name)
    {
        if (!isset($this->fileSources[$name])) {
            throw new \InvalidArgumentException(sprintf('File source with name %s is not registered', $name));
        }

        return $this->fileSources[$name];
    }
}
