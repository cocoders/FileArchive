<?php

namespace spec\Cocoders\FileSource;

use Cocoders\FileSource\FileSource;
use Cocoders\FileSource\FileSourceRegistry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class FileSourceRegistrySpec
 * @package spec\Cocoders\FileSource
 * @mixin FileSourceRegistry
 */
class FileSourceRegistrySpec extends ObjectBehavior
{
    function it_allows_to_register_file_source(FileSource $newFileSource, FileSource $dummyFileSource)
    {
        $this->register('newFileSource', $newFileSource);
        $this->register('dummyFileSource', $dummyFileSource);

        $this->get('newFileSource')->shouldBe($newFileSource);
        $this->get('dummyFileSource')->shouldBe($dummyFileSource);
    }

    function it_does_not_allow_to_get_not_registered_file_source(FileSource $newFileSource)
    {
        $this->register('newFileSource', $newFileSource);

        $this->shouldThrow('\InvalidArgumentException')->duringGet('dummyFileSource');
    }

}
