<?php

namespace spec\Cocoders\Archive;

use Cocoders\Archive\InMemoryArchiveFactory;
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
        $this->create('Archive')->shouldHaveType('Cocoders\Archive\InMemoryArchive');
    }
}
