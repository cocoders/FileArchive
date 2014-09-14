<?php

namespace Cocoders\Archive\InMemoryArchive;

use Cocoders\Archive\Archive;
use Cocoders\Archive\ArchiveRepository;

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

    public function findAll()
    {
        return $this->archives;
    }
}
