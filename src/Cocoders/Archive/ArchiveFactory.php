<?php

namespace Cocoders\Archive;

interface ArchiveFactory
{
    /**
     * @param $name
     * @return Archive
     */
    public function create($name);
}
