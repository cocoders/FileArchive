<?php

namespace Cocoders\Archive;

interface ArchiveFactory
{
    /**
     * @param $name
     * @param $archiveFiles ArchiveFile[]
     * @return Archive
     */
    public function create($name, $archiveFiles);
}
