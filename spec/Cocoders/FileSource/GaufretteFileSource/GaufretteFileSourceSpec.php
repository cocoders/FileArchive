<?php

namespace spec\Cocoders\FileSource\GaufretteFileSource;

use Cocoders\FileSource\File;
use Gaufrette\Filesystem;
use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GaufretteFileSourceSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        vfsStream::setup('tmp/12a');
        $this->beConstructedWith($filesystem, vfsStream::url('tmp/12a'));
    }

    function it_is_file_source()
    {
        $this->shouldHaveType('Cocoders\FileSource\FileSource');
    }

    function it_fetches_filesource_files_base_on_gaufrette_filesystem(Filesystem $filesystem)
    {
        $filesystem->listKeys('test')->willReturn([
            'keys' => [
                'test/aaa/z.txt',
                'test/aaa/test2.txt',
                'test.txt'
            ],
            'dirs' => [
                'test/aaa'
            ]
        ]);

        $filesystem->read('test/aaa/z.txt')->willReturn('Some content');
        $filesystem->read('test/aaa/test2.txt')->willReturn('Other text content');

        $files = $this->getFiles('test');

        $files[0]->shouldBeAnInstanceOf('Cocoders\FileSource\File');
        $files[0]->path->shouldBe('vfs://tmp/12a/test/aaa/z.txt');
        $files[1]->shouldBeAnInstanceOf('Cocoders\FileSource\File');
        $files[1]->path->shouldBe('vfs://tmp/12a/test/aaa/test2.txt');
    }

    function it_saves_content_of_files_from_gaufrette_at_local_disk(Filesystem $filesystem)
    {
        $filesystem->listKeys('test')->willReturn([
            'keys' => [
                'test/aaa/z.txt',
                'test/aaa/test2.txt',
                'test.txt'
            ],
            'dirs' => [
                'test/aaa'
            ]
        ]);

        $filesystem->read('test/aaa/z.txt')->willReturn('Some content');
        $filesystem->read('test/aaa/test2.txt')->willReturn('Other text content');

        $files = $this->getFiles('test');

        $files[0]->shouldBeAnInstanceOf('Cocoders\FileSource\File');
        $files[0]->shouldHaveContent('Some content');
        $files[1]->shouldBeAnInstanceOf('Cocoders\FileSource\File');
        $files[1]->shouldHaveContent('Other text content');
    }

    public function getMatchers()
    {
        return [
            'haveContent' => function(File $file, $content) {
                return file_get_contents($file->path) === $content;
            }
        ];
    }
}
