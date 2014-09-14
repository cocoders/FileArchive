<?php

namespace spec\Cocoders\UseCase\ArchiveList;

use Cocoders\Archive\Archive;
use Cocoders\Archive\ArchiveRepository;
use Cocoders\Upload\UploadedArchive\UploadedArchive;
use Cocoders\UseCase\ArchiveList\ArchiveListResponder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArchiveListUseCaseSpec extends ObjectBehavior
{
    function let(ArchiveRepository $archiveRepository)
    {
        $this->beConstructedWith($archiveRepository);
    }

    function it_list_archives(
        ArchiveRepository $archiveRepository,
        Archive $archive,
        UploadedArchive $uploadedArchive
    )
    {
        $archive->getName()->willReturn('first');
        $uploadedArchive->getName()->willReturn('second');

        $archiveRepository
            ->findAll()
            ->willReturn([
                $archive,
                $uploadedArchive
            ])
            ->shouldBeCalled()
        ;

        $this->execute();
    }

    function it_passes_listed_archives_to_responder(
        ArchiveListResponder $archiveListResponder,
        ArchiveRepository $archiveRepository,
        Archive $archive,
        UploadedArchive $uploadedArchive
    )
    {
        $archive->getName()->willReturn('first');
        $uploadedArchive->getName()->willReturn('second');

        $this->addResponder($archiveListResponder);
        $archiveRepository
            ->findAll()
            ->willReturn([
                $archive,
                $uploadedArchive
            ])
            ->shouldBeCalled()
        ;

        $archiveListResponder
            ->archiveListFechted(Argument::that(function ($response) {
                return
                    $response->items[0]->archiveName == 'first' &&
                    $response->items[0]->uploaded == false &&
                    $response->items[1]->archiveName == 'second' &&
                    $response->items[1]->uploaded == true
                ;
            }))
            ->shouldBeCalled()
        ;

        $this->execute();
    }
}
