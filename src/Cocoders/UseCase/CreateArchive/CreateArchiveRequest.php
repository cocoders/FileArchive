<?php

namespace Cocoders\UseCase\CreateArchive;

class CreateArchiveRequest
{
    public $archiveName;
    public $fileSource;
    public $path;

    public function __construct($fileSourceName, $archiveName, $path)
    {
        $this->fileSource = $fileSourceName;
        $this->archiveName = $archiveName;
        $this->path = $path;
    }
}
