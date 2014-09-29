<?php

namespace Cocoders\Upload\UploadedArchive;


interface UploadedArchiveRepository
{
    public function add(UploadedArchive $archive);
} 