<?php

namespace Cocoders\FileSource\GaufretteFileSource;

use Cocoders\FileSource\File;
use Cocoders\FileSource\FileSource;
use Gaufrette\Filesystem;

class GaufretteFileSource implements FileSource
{
    /**
     * @var \Gaufrette\Filesystem
     */
    private $filesystem;
    /**
     * @var string
     */
    private $tmpPath;

    public function __construct(Filesystem $filesystem, $tmpPath)
    {
        $this->filesystem = $filesystem;
        $this->tmpPath = $tmpPath;
    }

    /**
     * @param $path
     * @return array|\Cocoders\FileSource\File[]
     */
    public function getFiles($path)
    {
        $listedKeys = $this->filesystem->listKeys($path);

        $files = [];
        foreach ($listedKeys['dirs'] as $key) {
            $dirPath = str_replace($path, $this->tmpPath, $key);
            mkdir($dirPath, 0700, true);
        }
        foreach ($listedKeys['keys'] as $key) {
            $filePath = str_replace($path, $this->tmpPath, $key);
            file_put_contents(
                $filePath,
                $this->filesystem->read($key)
            );
            $files[] = new File($filePath);
        }

        return $files;
    }
}
