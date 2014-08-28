<?php

namespace spec\Cocoders\Archive;

use Cocoders\Archive\InMemoryArchive;
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
        $this->beConstructedWith('archive');
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
