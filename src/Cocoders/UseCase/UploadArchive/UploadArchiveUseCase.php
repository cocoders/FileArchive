<?php

namespace Cocoders\UseCase\UploadArchive;

use Cocoders\Archive\ArchiveFile;
use Cocoders\Archive\ArchiveRepository;
use Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive\InMemoryUploadedArchive;
use Cocoders\Upload\UploadedArchive\UploadedArchiveFactory;
use Cocoders\Upload\UploadProvider\UploadProviderRegistry;

class UploadArchiveUseCase
{
    /**
     * @var \Cocoders\Upload\UploadedArchive\UploadedArchiveFactory
     */
    private $uploadedArchiveFactory;
    /**
     * @var \Cocoders\Upload\UploadProvider\UploadProviderRegistry
     */
    private $uploadProviderRegistry;
    /**
     * @var \Cocoders\Archive\ArchiveRepository
     */
    private $archiveRepository;
    /**
     * @var UploadArchiveResponder[]
     */
    private $responders = [];

    public function __construct(
        UploadedArchiveFactory $uploadedArchiveFactory,
        UploadProviderRegistry $uploadProviderRegistry,
        ArchiveRepository $archiveRepository
    )
    {
        $this->uploadedArchiveFactory = $uploadedArchiveFactory;
        $this->uploadProviderRegistry = $uploadProviderRegistry;
        $this->archiveRepository = $archiveRepository;
    }

    public function addResponder(UploadArchiveResponder $responder)
    {
        $this->responders[] = $responder;
    }

    public function execute(UploadArchiveRequest $request)
    {
        $archive = $this->archiveRepository->findByName($request->archiveName);
        if (!$archive) {
            $this->archiveNotFound($request->archiveName);

            return;
        }

        $archiveFilePaths = array_map(
            function (ArchiveFile $archiveFile) {
                return $archiveFile->getPath();
            },
            $archive->getFiles()
        );

        $providers = [];
        foreach ($request->providersNames as $providerName) {
            $provider = $this->uploadProviderRegistry->get($providerName);
            $provider->upload($archiveFilePaths);
            $providers[] = $provider;
        }

        $uploadedArchive = $this->uploadedArchiveFactory->create($archive, $providers);

        $this->archiveRepository->add($uploadedArchive);

        $this->archiveUploaded($request->archiveName);
    }

    /**
     * @param string
     */
    private function archiveNotFound($archiveName)
    {
        foreach ($this->responders as $responder) {
            $responder->archiveNotFound($archiveName);
        }
    }

    /**
     * @param string
     */
    private function archiveUploaded($archiveName)
    {
        foreach ($this->responders as $responder) {
            $responder->archiveUploaded($archiveName);
        }
    }
}
