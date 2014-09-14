<?php

namespace Cocoders\UseCase\ArchiveList;

use Cocoders\UseCase\Responder;

interface ArchiveListResponder extends Responder
{
    public function archiveListFechted(ArchiveListResponse $archiveListResponse);
} 