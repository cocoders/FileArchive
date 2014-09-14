<?php

namespace spec\Cocoders\Upload\UploadProvider\InMemoryUploadProvider;

use Cocoders\Upload\UploadProvider\InMemoryUploadProvider\InMemoryUploadProvider;
use Cocoders\Upload\UploadProvider\UploadProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class InMemoryUploadProviderSpec
 * @package spec\Cocoders\UploadProvider\InMemoryUploadProvider
 * @mixin \Cocoders\Upload\UploadProvider\InMemoryUploadProvider\InMemoryUploadProvider
 */
class InMemoryUploadProviderSpec extends ObjectBehavior
{
    function it_allows_to_register_upload_provider(UploadProvider $newProvider)
    {
        $this->registerUploadProvider('newProvider', $newProvider);

        $this->get('newProvider')->shouldBe($newProvider);
    }

    function it_does_not_allow_to_get_not_registered_upload_provider(UploadProvider $uploadProvider)
    {
        $this->registerUploadProvider('newProvider', $uploadProvider);

        $this->shouldThrow('\InvalidArgumentException')->duringGet('dummyProvider');
    }
}
