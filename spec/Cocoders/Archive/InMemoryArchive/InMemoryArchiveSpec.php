<?php

namespace spec\Cocoders\Archive\InMemoryArchive;

use Cocoders\Archive\ArchiveFile;
use Cocoders\Archive\InMemoryArchive\InMemoryArchive;
use PhpSpec\ObjectBehavior;

/**
 * Class InMemoryArchiveSpec
 * @package spec\Cocoders\Archive
 * @mixin InMemoryArchive
 */
class InMemoryArchiveSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('archive', [new ArchiveFile('test')]);
    }

    function it_is_archive_type()
    {
        $this->shouldHaveType('Cocoders\Archive\Archive');
    }

    function it_has_name()
    {
        $this->getName()->shouldReturn('archive');
    }
}
