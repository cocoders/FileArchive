<?php

namespace Cocoders\Archive;

interface ArchiveRepository
{
    public function add(Archive $archive);

    /**
     * @param $name
     * @return Archive
     */
    public function findByName($name);
}
