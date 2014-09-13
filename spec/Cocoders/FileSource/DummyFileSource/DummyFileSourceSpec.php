<?php

namespace spec\Cocoders\FileSource\DummyFileSource;

use Cocoders\FileSource\DummyFileSource\DummyFileSource;
use PhpSpec\ObjectBehavior;

/**
 * Class DummyFileSourceSpec
 * @package spec\Cocoders\DummyFileSource
 * @mixin DummyFileSource
 */
class DummyFileSourceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            [
                '/home/cocoders/aaa/a.jpg',
                '/home/cocoders/bbb/b.jpg',
                '/home/cocoders/bbb/b.wav'
            ]
        );
    }

    function it_is_file_source()
    {
        $this->shouldHaveType('\Cocoders\FileSource\FileSource');
    }

    function it_fetch_file_from_given_path()
    {
        $files = $this->getFiles($path = '/home/cocoders/bbb/');

        $files->shouldHaveCount(2);
        $files[0]->path->shouldBe('/home/cocoders/bbb/b.jpg');
        $files[1]->path->shouldBe('/home/cocoders/bbb/b.wav');
    }
}
