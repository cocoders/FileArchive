<?php

namespace Cocoders\Archive\InMemoryArchive;

use Cocoders\Archive\ArchiveFactory;

class InMemoryArchiveFactory implements ArchiveFactory
{
    public function create($name)
    {
        return new InMemoryArchive($name);
    }
}
