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
}
