<?php

namespace Cocoders\UseCase\UploadArchive;

use Cocoders\UseCase\Responder;

interface UploadArchiveResponder extends Responder
{
    /**
     * @param string $name
     * @return void
     */
    public function archiveUploaded($name);

    /**
     * @param string $name
     * @return void
     */
    public function archiveNotFound($name);
}
