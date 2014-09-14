<?php

namespace spec\Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive;

use Cocoders\Archive\Archive;
use Cocoders\Upload\UploadProvider\UploadProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InMemoryUploadedArchiveSpec extends ObjectBehavior
{
    function let(Archive $archive, UploadProvider $uploadProvider)
    {
        $this->beConstructedWith($archive, [$uploadProvider]);
    }

    function it_is_archive()
    {
        $this->beAnInstanceOf('Cocoders\Archive\Archive');
    }

    function it_is_archive_proxy(Archive $archive)
    {
        $archive->getName()->willReturn('Name');

        $this->getName()->shouldBe('Name');
    }

    function it_returns_providers(UploadProvider $uploadProvider)
    {
        $this->getProviders()->shouldReturn([$uploadProvider]);
    }
}
