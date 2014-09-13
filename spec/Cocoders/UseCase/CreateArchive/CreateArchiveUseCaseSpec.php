<?php

namespace spec\Cocoders\UseCase\CreateArchive;

use Cocoders\Archive\Archive;
use Cocoders\Archive\ArchiveFactory;
use Cocoders\Archive\ArchiveFile;
use Cocoders\Archive\ArchiveRepository;
use Cocoders\UseCase\CreateArchive\CreateArchiveRequest;
use Cocoders\UseCase\CreateArchive\CreateArchiveResponder;
use Cocoders\UseCase\CreateArchive\CreateArchiveUseCase;
use Cocoders\FileSource\File;
use Cocoders\FileSource\FileSource;
use Cocoders\FileSource\FileSourceRegistry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
        $archiveFactory->create(
            'name',
            Argument::that(
                function ($archiveFiles) {
                    foreach ($archiveFiles as $archiveFile) {
                        if (!$archiveFile instanceof ArchiveFile) {
                            return false;
                        }
                    }

                    return true;
                }
            )
        )->willReturn($archive);
        $archive->getName()->willReturn('name');

        $this->beConstructedWith($fileSourceRegistry, $archiveFactory, $archiveRepository);
    }

    function it_creates_archive(
        Archive $archive,
        ArchiveRepository $archiveRepository
    ) {
        $createArchiveRequest = new CreateArchiveRequest('dummy', 'name', 'path');

        $archiveRepository->add($archive)->shouldBeCalled();

        $this->execute($createArchiveRequest);
    }

    function it_notify_responders(CreateArchiveResponder $responder)
    {
        $this->addResponder($responder);
        $createArchiveRequest = new CreateArchiveRequest('dummy', 'name', 'path');

        $responder->archiveCreated('name')->shouldBeCalled();

        $this->execute($createArchiveRequest);

    }
}
