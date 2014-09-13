<?php

namespace Cocoders\Archive;

interface ArchiveRepository
{
    /**
     * @param Archive $archive
     * @return void
     */
    public function add(Archive $archive);

    /**
     * @param string $name
     * @return Archive[]
     */
    public function findByName($name);
}
