<?php

namespace Cocoders\UseCase\CreateArchive;

interface CreateArchiveResponder
{
    /**
     * @param string $name
     * @return mixed
     */
    public function archiveCreated($name);
}
