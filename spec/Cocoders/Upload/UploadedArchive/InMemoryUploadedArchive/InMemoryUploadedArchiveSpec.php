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

    function it_returns_providers(UploadProvider $uploadProvider)
    {
        $this->getProviders()->shouldReturn([$uploadProvider]);
    }
}
