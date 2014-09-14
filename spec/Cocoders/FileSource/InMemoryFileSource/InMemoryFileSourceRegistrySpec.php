<?php

namespace spec\Cocoders\FileSource\InMemoryFileSource;

use Cocoders\FileSource\FileSource;
use Cocoders\FileSource\InMemoryFileSource\InMemoryFileSourceRegistry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class FileSourceRegistrySpec
 * @package spec\Cocoders\FileSource
 * @mixin InMemoryFileSourceRegistry
 */
class InMemoryFileSourceRegistrySpec extends ObjectBehavior
{
    function it_allows_to_register_file_source(FileSource $newFileSource, FileSource $dummyFileSource)
    {
        $this->registerFileSource('newFileSource', $newFileSource);
        $this->registerFileSource('dummyFileSource', $dummyFileSource);

        $this->get('newFileSource')->shouldBe($newFileSource);
        $this->get('dummyFileSource')->shouldBe($dummyFileSource);
    }

    function it_does_not_allow_to_get_not_registered_file_source(FileSource $newFileSource)
    {
        $this->registerFileSource('newFileSource', $newFileSource);

        $this->shouldThrow('\InvalidArgumentException')->duringGet('dummyFileSource');
    }

}
