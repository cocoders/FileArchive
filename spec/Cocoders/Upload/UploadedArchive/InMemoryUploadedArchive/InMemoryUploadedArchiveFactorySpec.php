<?php

namespace spec\Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive;

use Cocoders\Archive\Archive;
use Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive\InMemoryUploadedArchiveFactory;
use Cocoders\Upload\UploadProvider\UploadProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class InMemoryUploadedArchiveFactorySpec
 * @package spec\Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive
 * @mixin InMemoryUploadedArchiveFactory
 */
class InMemoryUploadedArchiveFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive\InMemoryUploadedArchiveFactory');
    }

    function it_creates_in_memory_uploaded_archive(Archive $archive, UploadProvider $uploadProvider)
    {
        $this->create($archive, [$uploadProvider])->shouldBeAnInstanceOf('Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive\InMemoryUploadedArchive');
    }
}
