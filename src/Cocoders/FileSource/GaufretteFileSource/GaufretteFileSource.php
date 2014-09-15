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
        foreach ($listedKeys['keys'] as $key) {
            $filePath = $this->tmpPath . '/' . $key;
            $this->createBaseDirectory($filePath);
            if ($this->isNotInRootDir($filePath)) {
                file_put_contents(
                    $filePath,
                    $this->filesystem->read($key)
                );
                $files[] = new File($filePath);
            }
        }

        return $files;
    }

    /**
     * @param string $filePath
     */
    private function createBaseDirectory($filePath)
    {
        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0700, true);
        }
    }

    /**
     * @param string $filePath
     * @return boolean
     */
    private function isNotInRootDir($filePath)
    {
        return dirname($filePath) !== $this->tmpPath;
    }
}
