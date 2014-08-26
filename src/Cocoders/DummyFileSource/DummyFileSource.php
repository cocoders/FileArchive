<?php

namespace Cocoders\DummyFileSource;

use Cocoders\FileSource\File;
use Cocoders\FileSource\FileSource;

class DummyFileSource implements FileSource
{
    private $paths;

    public function __construct($paths)
    {
        $this->paths = $paths;
    }

    public function getFiles($parentPath)
    {
        $selectedPaths = array_filter(
            $this->paths,
            function ($path) use ($parentPath) {
                return strpos($path, $parentPath) !== false;
            }
        );

        return array_values(array_map(
            function ($selectedPath) {
                return new File($selectedPath);
            },
            $selectedPaths
        ));
    }
}
