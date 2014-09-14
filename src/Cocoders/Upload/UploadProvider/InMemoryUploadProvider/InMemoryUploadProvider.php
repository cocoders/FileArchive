<?php

namespace Cocoders\Upload\UploadProvider\InMemoryUploadProvider;

use Cocoders\Upload\UploadProvider\UploadProvider;
use Cocoders\Upload\UploadProvider\UploadProviderRegistry;

class InMemoryUploadProvider implements UploadProviderRegistry
{
    private $uploadProviders = [];

    public function register($name, UploadProvider $uploadProvider)
    {
        $this->uploadProviders[$name] = $uploadProvider;
    }

    public function get($name)
    {
        if (!isset($this->uploadProviders[$name])) {
            throw new \InvalidArgumentException(sprintf('Upload provider with name %s is not registered', $name));
        }

        return $this->uploadProviders[$name];
    }
}
