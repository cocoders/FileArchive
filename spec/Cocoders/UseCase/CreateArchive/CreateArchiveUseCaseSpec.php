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
        Archive $existingArchive,
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

        $archiveFactory->create(
            'existingName',
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
        )->willReturn($existingArchive);

        $archive->getName()->willReturn('name');
        $existingArchive->getName()->willReturn('existingName');
        $archiveRepository->findByName("name")->willReturn(null);
        $archiveRepository->findByName("existingName")->willReturn($existingArchive);

        $this->beConstructedWith($fileSourceRegistry, $archiveFactory, $archiveRepository);
    }

    function it_creates_archive(
        Archive $archive,
        ArchiveRepository $archiveRepository
    ) {
        $createArchiveRequest = new CreateArchiveRequest('dummy', 'name', 'path');

        $archiveRepository->findByName("name")->shouldBeCalled();
        $archiveRepository->add($archive)->shouldBeCalled();

        $this->execute($createArchiveRequest);
    }

    function it_does_not_create_archive_that_already_exists(
        Archive $existingArchive,
        ArchiveRepository $archiveRepository
    ) {
        $createArchiveRequest = new CreateArchiveRequest('dummy', 'existingName', 'path');

        $archiveRepository->findByName("existingName")->shouldBeCalled();
        $archiveRepository->add($existingArchive)->shouldNotBeCalled();

        $this->execute($createArchiveRequest);
    }

    function it_notify_responders_when_archive_is_created(
        CreateArchiveResponder $responder,
        ArchiveRepository $archiveRepository,
        Archive $archive
    )
    {
        $this->addResponder($responder);
        $createArchiveRequest = new CreateArchiveRequest('dummy', 'name', 'path');

        $archiveRepository->add($archive)->willReturn();
        $responder->archiveCreated('name')->shouldBeCalled();
        $responder->archiveAlreadyExists('name')->shouldNotBeCalled();

        $this->execute($createArchiveRequest);

    }

    function it_notify_responders_when_archive_is_not_created(CreateArchiveResponder $responder)
    {
        $this->addResponder($responder);
        $createArchiveRequest = new CreateArchiveRequest('dummy', 'existingName', 'path');

        $responder->archiveCreated('existingName')->shouldNotBeCalled();
        $responder->archiveAlreadyExists('existingName')->shouldBeCalled();

        $this->execute($createArchiveRequest);

    }
}
