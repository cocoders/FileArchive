<?php

namespace spec\Cocoders\UseCase\UploadArchive;

use Cocoders\Archive\Archive;
use Cocoders\Archive\ArchiveFile;
use Cocoders\Archive\ArchiveRepository;
use Cocoders\Upload\UploadedArchive\UploadedArchive;
use Cocoders\Upload\UploadedArchive\UploadedArchiveFactory;
use Cocoders\Upload\UploadProvider\UploadProvider;
use Cocoders\Upload\UploadProvider\UploadProviderRegistry;
use Cocoders\UseCase\UploadArchive\UploadArchiveRequest;
use Cocoders\UseCase\UploadArchive\UploadArchiveResponder;
use Cocoders\UseCase\UploadArchive\UploadArchiveUseCase;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UploadArchiveUseCaseSpec
 * @package spec\Cocoders\UseCase\UploadArchive
 * @mixin UploadArchiveUseCase
 */
class UploadArchiveUseCaseSpec extends ObjectBehavior
{
    function let(
        UploadedArchiveFactory $uploadedArchiveFactory,
        UploadProviderRegistry $uploadProviderRegistry,
        ArchiveRepository $archiveRepository,
        Archive $archive,
        UploadProvider $provider,
        UploadedArchive $uploadedArchive,
        UploadedArchiveFactory $uploadedArchiveFactory
    )
    {
        $archiveRepository->findByName('myArchiveName')->willReturn($archive);
        $uploadProviderRegistry->get('myProvider1')->willReturn($provider);
        $archive->getFiles()->willReturn([new ArchiveFile('/home/cocoders/aaa/a.jpg')]);
        $provider->upload('myArchiveName', ['/home/cocoders/aaa/a.jpg'])->willReturn();
        $uploadedArchiveFactory->create($archive, [$provider])->willReturn($uploadedArchive);
        $archiveRepository->add($uploadedArchive)->willReturn();

        $this->beConstructedWith($uploadedArchiveFactory, $uploadProviderRegistry, $archiveRepository);
    }

    function it_pass_archive_files_to_providers(
        UploadProvider $provider
    )
    {
        $provider->upload('myArchiveName', ['/home/cocoders/aaa/a.jpg'])->shouldBeCalled();

        $this->execute(new UploadArchiveRequest('myArchiveName', ['myProvider1']));
    }

    function it_saves_uploaded_archive_after_upload(
        ArchiveRepository $archiveRepository,
        UploadedArchive $uploadedArchive
    )
    {
        $archiveRepository->add($uploadedArchive)->shouldBeCalled();

        $this->execute(new UploadArchiveRequest('myArchiveName', ['myProvider1']));
    }

    function it_notify_responders_when_archive_is_uploaded(
        UploadArchiveResponder $responder
    )
    {
        $this->addResponder($responder);

        $responder->archiveUploaded('myArchiveName')->shouldBeCalled();

        $this->execute(new UploadArchiveRequest('myArchiveName', ['myProvider1']));
    }

    function it_notify_responders_when_archive_is_not_found(
        ArchiveRepository $archiveRepository,
        UploadArchiveResponder $responder
    )
    {
        $archiveRepository->findByName('myArchiveName')->willReturn(null);
        $this->addResponder($responder);

        $responder->archiveNotFound('myArchiveName')->shouldBeCalled();

        $this->execute(new UploadArchiveRequest('myArchiveName', ['myProvider1']));
    }
}
