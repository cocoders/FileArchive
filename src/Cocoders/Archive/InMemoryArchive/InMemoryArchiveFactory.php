<?php

namespace Cocoders\Archive\InMemoryArchive;

use Cocoders\Archive\ArchiveFactory;

class InMemoryArchiveFactory implements ArchiveFactory
{
    public function create($name, $archiveFiles)
    {
        $archive = new InMemoryArchive($name);
        foreach ($archiveFiles as $archiveFile) {
            $archive->addFile($archiveFile);
        }

        return $archive;
    }
}
