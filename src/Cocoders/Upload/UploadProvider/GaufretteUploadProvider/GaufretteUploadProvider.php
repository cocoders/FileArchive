<?php

namespace Cocoders\Upload\UploadProvider\GaufretteUploadProvider;

use Cocoders\Upload\UploadProvider\UploadProvider;
use Gaufrette\Filesystem;

class GaufretteUploadProvider implements UploadProvider
{
    /**
     * @var \Gaufrette\Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function upload($name, $paths)
    {
        $rootParent = $this->fetchRootPath($paths);

        foreach ($paths as $path) {
            $key = $this->generateKey($name, $rootParent, $path);
            $this->filesystem->write($key, file_get_contents($path));
        }
    }

    private function getParentPath($path)
    {
        return dirname($path);
    }

    /**
     * @param $paths
     * @return string
     */
    private function fetchRootPath($paths)
    {
        $rootParent = '/';
        foreach ($paths as $path) {
            if ($rootParent != $this->getParentPath($path)) {
                $rootParent = $this->getParentPath($path);
            }
        }

        return $rootParent;
    }

    /**
     * @param string $name
     * @param string $rootParent
     * @param $path
     * @return string
     */
    private function generateKey($name, $rootParent, $path)
    {
        return str_replace($rootParent, $name, $path);
    }
}
