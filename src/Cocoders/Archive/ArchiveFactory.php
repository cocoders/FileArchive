<?php

namespace Cocoders\Archive;

interface ArchiveFactory
{
    /**
     * @param String $name
     * @param ArchiveFile[] $archiveFiles
     * @return Archive
     */
    public function create($name, $archiveFiles);
}
