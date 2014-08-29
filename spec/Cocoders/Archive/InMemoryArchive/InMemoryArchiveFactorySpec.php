<?php

namespace spec\Cocoders\Archive\InMemoryArchive;

use Cocoders\Archive\ArchiveFile;
use Cocoders\Archive\InMemoryArchive\InMemoryArchiveFactory;
use PhpSpec\ObjectBehavior;

/**
 * Class InMemoryArchiveFactorySpec
 * @package spec\Cocoders\Archive
 * @mixin InMemoryArchiveFactory
 */
class InMemoryArchiveFactorySpec extends ObjectBehavior
{
    function it_is_archive_factory_type()
    {
        $this->shouldHaveType('Cocoders\Archive\ArchiveFactory');
    }

    function it_creates_in_memory_archive_source()
    {
        $archiveFiles =  [new ArchiveFile('path')];
        $this->create('Archive',$archiveFiles)->shouldHaveType('Cocoders\Archive\InMemoryArchive\InMemoryArchive');
    }
}
