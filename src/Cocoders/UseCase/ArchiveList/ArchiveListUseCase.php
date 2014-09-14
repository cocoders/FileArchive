<?php

namespace Cocoders\UseCase\ArchiveList;

use Cocoders\Archive\ArchiveRepository;
use Cocoders\Upload\UploadedArchive\UploadedArchive;
use Cocoders\UseCase\ResponderAware;
use Cocoders\UseCase\ResponderAwareBehavior;

class ArchiveListUseCase implements ResponderAware
{
    use ResponderAwareBehavior;

    /**
     * @var \Cocoders\Archive\ArchiveRepository
     */
    private $archiveRepository;

    public function __construct(ArchiveRepository $archiveRepository)
    {
        $this->archiveRepository = $archiveRepository;
    }

    public function execute()
    {
        $archives = $this->archiveRepository->findAll();

        $archivesItems = $this->fetchArchiveItems($archives);
        $this->archiveListFetched($archivesItems);
    }

    /**
     * @param $archives
     * @return array
     */
    private function fetchArchiveItems($archives)
    {
        $archivesItems = [];
        foreach ($archives as $archive) {
            $isUploaded = $archive instanceof UploadedArchive;
            $archivesItems[] = new ArchiveListItem($archive->getName(), $isUploaded);
        }

        return $archivesItems;
    }

    /**
     * @param $archivesItems
     */
    private function archiveListFetched($archivesItems)
    {
        foreach ($this->responders as $responder) {
            /**
             * @var ArchiveListResponder $responder
             */
            $responder->archiveListFechted(new ArchiveListResponse($archivesItems));
        }
    }
}
