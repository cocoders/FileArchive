<?php

namespace Cocoders\UseCase\CreateArchive;

use Cocoders\UseCase\Responder;

interface CreateArchiveResponder extends Responder
{
    /**
     * @param string $name
     * @return mixed
     */
    public function archiveCreated($name);
}
