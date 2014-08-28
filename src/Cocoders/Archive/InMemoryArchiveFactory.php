<?php

namespace Cocoders\Archive;

class InMemoryArchiveFactory implements ArchiveFactory
{
    public function create($name)
    {
        return new InMemoryArchive($name);
    }
}
