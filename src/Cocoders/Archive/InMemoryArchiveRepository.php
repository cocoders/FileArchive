<?php

namespace Cocoders\Archive;

class InMemoryArchiveRepository implements ArchiveRepository
{
    /** @var array|Archive[] */
    private $archives = [];

    public function add(Archive $archive)
    {
        $this->archives[] = $archive;
    }

    public function findByName($name)
    {
        foreach ($this->archives as $archive) {
            if ($archive->getName() == $name) {
                return $archive;
            }
        }

        return null;
    }
}
