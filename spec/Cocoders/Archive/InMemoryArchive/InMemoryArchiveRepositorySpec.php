<?php

namespace spec\Cocoders\Archive\InMemoryArchive;

use Cocoders\Archive\Archive;
use Cocoders\Archive\InMemoryArchive\InMemoryArchiveRepository;
use PhpSpec\ObjectBehavior;

/**
 * Class InMemoryArchiveRepositorySpec
 * @package spec\Cocoders\Archive
 * @mixin InMemoryArchiveRepository
 */
class InMemoryArchiveRepositorySpec extends ObjectBehavior
{
    function it_is_archive_repository_type()
    {
        $this->shouldHaveType('Cocoders\Archive\ArchiveRepository');
    }

    function it_adds_archive_to_repository(Archive $archive)
    {
        $archive->getName()->willReturn('archiveName');

        $this->add($archive);

        $this->findByName('archiveName')->shouldReturn($archive);
    }

    function it_returns_null_when_there_is_no_archive()
    {
        $this->findByName('archive')->shouldReturn(null);
    }

    function it_list_all_archives(Archive $archive1, Archive $archive2)
    {
        $this->add($archive1);
        $this->add($archive2);

        $this->findAll()->shouldBe([
            $archive1,
            $archive2
        ]);
    }
}

