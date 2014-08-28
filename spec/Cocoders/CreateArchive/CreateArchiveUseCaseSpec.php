<?php

namespace spec\Cocoders\CreateArchive;

use Cocoders\Archive\Archive;
use Cocoders\Archive\ArchiveFactory;
use Cocoders\Archive\ArchiveRepository;
use Cocoders\CreateArchive\CreateArchiveRequest;
use Cocoders\CreateArchive\CreateArchiveResponder;
use Cocoders\CreateArchive\CreateArchiveUseCase;
use Cocoders\FileSource\File;
use Cocoders\FileSource\FileSource;
use Cocoders\FileSource\FileSourceRegistry;
use PhpSpec\ObjectBehavior;

/**
 * Class CreateArchiveUseCaseSpec
 * @package spec\Cocoders\CreateArchive
 * @mixin CreateArchiveUseCase
 */
class CreateArchiveUseCaseSpec extends ObjectBehavior
{
    function let(
        FileSourceRegistry $fileSourceRegistry,
        ArchiveFactory $archiveFactory,
        ArchiveRepository $archiveRepository,
        FileSource $fileSource,
        Archive $archive,
        ArchiveRepository $archiveRepository,
        File $file
    ) {
        $fileSourceRegistry->get('dummy')->willReturn($fileSource);
        $fileSource->getFiles('path')->willReturn([$file]);
        $archiveFactory->create('name')->willReturn($archive);

        $this->beConstructedWith($fileSourceRegistry, $archiveFactory, $archiveRepository);
    }

    function it_creates_archive(
        Archive $archive,
        ArchiveRepository $archiveRepository
    )
    {
        $createArchiveRequest = new CreateArchiveRequest('dummy', 'name', 'path');

        $archiveRepository->add($archive)->shouldBeCalled();

        $this->execute($createArchiveRequest);
    }

    function it_notify_responders(CreateArchiveResponder $responder)
    {
        $this->addResponder($responder);
        $createArchiveRequest = new CreateArchiveRequest('dummy', 'name', 'path');

        $responder->archiveCreated()->shouldBeCalled();

        $this->execute($createArchiveRequest);

    }
}
