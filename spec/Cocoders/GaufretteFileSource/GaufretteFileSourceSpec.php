<?php

namespace spec\Cocoders\GaufretteFileSource;

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
        $filesystem->listKeys('/home/somekey')->willReturn([
            'keys' => [
                '/home/somekey/aaa/test.txt',
                '/home/somekey/aaa/test2.txt',
                '/home/somekey/bbb/a.txt'
            ],
            'dirs' => [
                '/home/somekey/aaa',
                '/home/somekey/bbb'
            ]
        ]);

        $filesystem->read('/home/somekey/aaa/test.txt')->willReturn('Some content');
        $filesystem->read('/home/somekey/aaa/test2.txt')->willReturn('Other text content');
        $filesystem->read('/home/somekey/bbb/a.txt')->willReturn('A text content');

        $files = $this->getFiles('/home/somekey');

        $files[0]->shouldBeAnInstanceOf('Cocoders\FileSource\File');
        $files[0]->path->shouldBe('vfs://tmp/12a/aaa/test.txt');
        $files[1]->shouldBeAnInstanceOf('Cocoders\FileSource\File');
        $files[1]->path->shouldBe('vfs://tmp/12a/aaa/test2.txt');
        $files[2]->shouldBeAnInstanceOf('Cocoders\FileSource\File');
        $files[2]->path->shouldBe('vfs://tmp/12a/bbb/a.txt');
    }

    function it_saves_content_of_files_from_gaufrette_at_local_disk(Filesystem $filesystem)
    {
        $filesystem->listKeys('/home/somekey')->willReturn([
            'keys' => [
                '/home/somekey/aaa/test.txt',
                '/home/somekey/aaa/test2.txt',
                '/home/somekey/bbb/a.txt'
            ],
            'dirs' => [
                '/home/somekey/aaa',
                '/home/somekey/bbb'
            ]
        ]);

        $filesystem->read('/home/somekey/aaa/test.txt')->willReturn('Some content');
        $filesystem->read('/home/somekey/aaa/test2.txt')->willReturn('Other text content');
        $filesystem->read('/home/somekey/bbb/a.txt')->willReturn('A text content');

        $files = $this->getFiles('/home/somekey');

        $files[0]->shouldHaveContent('Some content');
        $files[1]->shouldHaveContent('Other text content');
        $files[2]->shouldHaveContent('A text content');
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
