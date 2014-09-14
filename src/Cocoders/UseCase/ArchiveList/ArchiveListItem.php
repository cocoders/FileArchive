<?php

namespace Cocoders\UseCase\ArchiveList;

class ArchiveListItem
{
    public $archiveName;
    public $uploaded;

    /**
     * @param string $archiveName
     */
    public function __construct($archiveName, $uploaded = false)
    {
        $this->archiveName = $archiveName;
        $this->uploaded = $uploaded;
    }
}
