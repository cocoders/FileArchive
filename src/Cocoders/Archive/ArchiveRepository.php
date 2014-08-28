<?php

namespace Cocoders\Archive;

interface ArchiveRepository
{
    public function add(Archive $archive);
    public function findByName($name);
}
