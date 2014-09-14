<?php

namespace Cocoders\UseCase\CreateArchive;

use Cocoders\Archive\Archive;
use Cocoders\Archive\ArchiveFactory;
use Cocoders\Archive\ArchiveFile;
use Cocoders\Archive\ArchiveRepository;
use Cocoders\FileSource\FileSourceRegistry;
use Cocoders\UseCase\ResponderAware;
use Cocoders\UseCase\ResponderAwareBehavior;

class CreateArchiveUseCase implements ResponderAware
{
    use ResponderAwareBehavior;

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

    public function __construct(FileSourceRegistry $fileSourceRegistry, ArchiveFactory $archiveFactory, ArchiveRepository $archiveRepository)
    {
        $this->fileSourceRegistry = $fileSourceRegistry;
        $this->archiveFactory = $archiveFactory;
        $this->archiveRepository = $archiveRepository;
    }

    public function execute(CreateArchiveRequest $request)
    {
        $fileSource = $this->fileSourceRegistry->get($request->fileSource);
        $files = $fileSource->getFiles($request->path);

        $archiveFiles = [];
        foreach ($files as $file) {
            $archiveFiles[] = new ArchiveFile($file->path);
        }

        $archive = $this->archiveFactory->create($request->archiveName, $archiveFiles);
        $this->archiveRepository->add($archive);

        $this->archiveCreated($archive);
    }

    /**
     * @param $archive
     */
    private function archiveCreated(Archive $archive)
    {
        foreach ($this->responders as $responder) {
            /**
             * @var CreateArchiveResponder $responder
             */
            $responder->archiveCreated($archive->getName());
        }
    }
}
