<?php

namespace Cocoders\UseCase\UploadArchive;

interface UploadArchiveResponder
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
