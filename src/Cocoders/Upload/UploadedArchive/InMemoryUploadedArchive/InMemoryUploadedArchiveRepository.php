<?php

namespace Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive;


use Cocoders\Upload\UploadedArchive\UploadedArchive;
use Cocoders\Upload\UploadedArchive\UploadedArchiveRepository;

class InMemoryUploadedArchiveRepository implements UploadedArchiveRepository
{
    private $uploadedArchives = [];

    public function add(UploadedArchive $archive)
    {
        $this->uploadedArchives[] = $archive;
    }
}