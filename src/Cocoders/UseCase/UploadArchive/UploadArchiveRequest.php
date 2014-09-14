<?php

namespace Cocoders\UseCase\UploadArchive;

class UploadArchiveRequest
{
    public $archiveName;
    public $providersNames;

    /**
     * @param string $archiveName
     * @param array $providersNames
     */
    public function __construct($archiveName, $providersNames)
    {
        $this->archiveName = $archiveName;
        $this->providersNames = $providersNames;
    }
}
