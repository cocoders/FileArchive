<?php

namespace spec\Cocoders\UseCase\UploadArchive;

use Cocoders\Archive\Archive;
use Cocoders\Archive\ArchiveFile;
use Cocoders\Archive\ArchiveRepository;
use Cocoders\Upload\UploadedArchive\UploadedArchive;
use Cocoders\Upload\UploadProvider\UploadProvider;
use Cocoders\Upload\UploadProvider\UploadProviderRegistry;
use Cocoders\UseCase\UploadArchive\UploadArchiveRequest;
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
    function let(UploadProviderRegistry $uploadProviderRegistry, ArchiveRepository $archiveRepository)
    {
        $this->beConstructedWith($uploadProviderRegistry, $archiveRepository);
    }

    function it_pass_archive_files_to_providers(
        UploadProviderRegistry $uploadProviderRegistry,
        ArchiveRepository $archiveRepository,
        Archive $archive,
        UploadProvider $provider
    )
    {
        $archiveRepository->findByName('myArchiveName')->willReturn($archive);
        $uploadProviderRegistry->get('myProvider1')->willReturn($provider);
        $archive->getFiles()->willReturn([new ArchiveFile('/home/cocoders/aaa/a.jpg')]);
        $provider->upload(['/home/cocoders/aaa/a.jpg'])->shouldBeCalled();

        $this->execute(new UploadArchiveRequest('myArchiveName', ['myProvider1']));
    }

    function it_saves_uploaded_archive_after_upload(
        UploadProviderRegistry $uploadProviderRegistry,
        ArchiveRepository $archiveRepository,
        Archive $archive,
        UploadProvider $provider
    )
    {
        $archiveRepository->findByName('myArchiveName')->willReturn($archive);
        $uploadProviderRegistry->get('myProvider1')->willReturn($provider);
        $archive->getFiles()->willReturn([new ArchiveFile('/home/cocoders/aaa/a.jpg')]);
        $provider->upload(['/home/cocoders/aaa/a.jpg'])->willReturn();
        $archiveRepository->add(Argument::that(function (UploadedArchive $archive) use ($provider) {
                    return $archive->getProviders() == [$provider->getWrappedObject()];
                }))->shouldBeCalled();


        $this->execute(new UploadArchiveRequest('myArchiveName', ['myProvider1']));
    }
}
