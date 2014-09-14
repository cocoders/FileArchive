<?php

namespace Cocoders\Archive;

interface Archive
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return ArchiveFile[]
     */
    public function getFiles();
}
