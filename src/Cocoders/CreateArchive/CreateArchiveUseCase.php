<?php

namespace Cocoders\CreateArchive;

use Cocoders\Archive\ArchiveFactory;
use Cocoders\Archive\ArchiveRepository;
use Cocoders\FileSource\FileSourceRegistry;

class CreateArchiveUseCase
{
    /**
     * @var \Cocoders\FileSource\FileSourceRegistry
     */
    private $fileSourceRegistry;

    /**
     * @var \Cocoders\Archive\ArchiveFactory
     */
    private $archiveFactory;

    /**
     * @var \Cocoders\Archive\ArchiveRepository
     */
    private $archiveRepository;

    /**
     * @var CreateArchiveResponder[]
     */
    private $responders = [];

    public function __construct(FileSourceRegistry $fileSourceRegistry, ArchiveFactory $archiveFactory, ArchiveRepository $archiveRepository)
    {
        $this->fileSourceRegistry = $fileSourceRegistry;
        $this->archiveFactory = $archiveFactory;
        $this->archiveRepository = $archiveRepository;
    }

    public function addResponder(CreateArchiveResponder $responder)
    {
        $this->responders[] = $responder;
    }

    public function execute(CreateArchiveRequest $request)
    {
        $fileSource = $this->fileSourceRegistry->get($request->fileSource);
        $files = $fileSource->getFiles($request->path);
        //@todo from files create archive files and add to archive
        $archive = $this->archiveFactory->create($request->name);
        $this->archiveRepository->add($archive);

        foreach ($this->responders as $responder) {
            $responder->archiveCreated($archive->getName());
        }
    }
}
