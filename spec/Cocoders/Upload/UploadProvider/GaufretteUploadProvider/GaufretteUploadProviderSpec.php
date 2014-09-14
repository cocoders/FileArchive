<?php

namespace spec\Cocoders\Upload\UploadProvider\GaufretteUploadProvider;

use Gaufrette\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use org\bovigo\vfs\vfsStream;

class GaufretteUploadProviderSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        vfsStream::setup('tmp', null, ['23a' => [
                'aaa' => [
                    'a.txt' => 'Test Cocoders content 123',
                    't.txt' => 'Test Cocoders content!'
                ],
                'bbb' => 'CDE !'
            ]
        ]);
        $this->beConstructedWith($filesystem);
    }

    function it_is_upload_provider()
    {
        $this->shouldBeAnInstanceOf('Cocoders\Upload\UploadProvider\UploadProvider');
    }

    function it_uploads_all_files_to_gaufrette(Filesystem $filesystem)
    {
        $filesystem->write('myArchive/aaa/a.txt', 'Test Cocoders content 123')->shouldBeCalled();
        $filesystem->write('myArchive/aaa/t.txt', 'Test Cocoders content!')->shouldBeCalled();
        $filesystem->write('myArchive/bbb', 'CDE !')->shouldBeCalled();
        $this->upload('myArchive', [vfsStream::url('tmp/23a/aaa/a.txt'), vfsStream::url('tmp/23a/aaa/t.txt'), vfsStream::url('tmp/23a/bbb')]);
    }
}
