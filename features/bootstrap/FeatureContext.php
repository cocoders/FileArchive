<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Cocoders\Archive\InMemoryArchive\InMemoryArchiveFactory;
use Cocoders\Archive\InMemoryArchive\InMemoryArchiveRepository;
use Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive\InMemoryUploadedArchiveFactory;
use Cocoders\Upload\UploadProvider\DummyUploadProvider\DummyUploadProvider;
use Cocoders\Upload\UploadProvider\InMemoryUploadProvider\InMemoryUploadProvider;
use Cocoders\UseCase\CreateArchive\CreateArchiveRequest;
use Cocoders\UseCase\CreateArchive\CreateArchiveUseCase;
use Cocoders\FileSource\DummyFileSource\DummyFileSource;
use Cocoders\FileSource\InMemoryFileSource\InMemoryFileSourceRegistry;
use Cocoders\UseCase\UploadArchive\UploadArchiveRequest;
use Cocoders\UseCase\UploadArchive\UploadArchiveResponder;
use Cocoders\UseCase\UploadArchive\UploadArchiveUseCase;

class FeatureContext implements SnippetAcceptingContext, UploadArchiveResponder
{
    public function __construct()
    {
        $this->lastUploadedArchiveName = null;
        $this->fileSourceRegistry = new InMemoryFileSourceRegistry();
        $this->archiveRepository = new InMemoryArchiveRepository();
        $this->archiveFactory = new InMemoryArchiveFactory();
        $this->uploadedArchiveFactory = new InMemoryUploadedArchiveFactory();
        $this->uploadProvidersRegistry = new InMemoryUploadProvider();
        $this->createArchiveUseCase = new CreateArchiveUseCase(
            $this->fileSourceRegistry,
            $this->archiveFactory,
            $this->archiveRepository
        );
        $this->uploadArchiveUseCase = new UploadArchiveUseCase(
            $this->uploadedArchiveFactory,
            $this->uploadProvidersRegistry,
            $this->archiveRepository
        );
        $this->uploadArchiveUseCase->addResponder($this);
    }

    /**
     * @Given There is dummy file source with following files:
     */
    public function thereIsDummyFileSourceWithFollowingFiles(TableNode $table)
    {
        $paths = array_map(
            function ($row) {
                return $row['path'];
            },
            $table->getHash()
        );

        $dummyFileSource = new DummyFileSource($paths);
        $this->fileSourceRegistry->register('dummy', $dummyFileSource);
    }

    /**
     * @When I create :arg1 archive from :arg2 directory using :arg3 file source
     */
    public function iCreateArchiveFromDirectoryUsingFilesource($archiveName, $path, $fileSourceName)
    {
        $this->createArchiveUseCase->execute(new CreateArchiveRequest($fileSourceName, $archiveName, $path));
    }

    /**
     * @Then I should see :arg1 archive on the archives list
     */
    public function iShouldSeeArchiveOnTheArchivesList($name)
    {
        PHPUnit_Framework_Assert::assertEquals($name, $this->archiveRepository->findByName($name)->getName());
    }

    /**
     * @Given There is :arg1 archive
     */
    public function thereIsArchive($archiveName)
    {
        $dummyFileSource = new DummyFileSource(            [
            '/home/cocoders/aaa/a.jpg',
            '/home/cocoders/bbb/b.jpg',
            '/home/cocoders/bbb/b.wav'
        ]);
        $this->fileSourceRegistry->register('dummy', $dummyFileSource);

        $this->iCreateArchiveFromDirectoryUsingFilesource($archiveName, '/home/cocoders/aaa/', 'dummy');
    }

    /**
     * @Given I have configured myProvider
     */
    public function iHaveConfiguredMyprovider()
    {
        $this->uploadProvidersRegistry->register('myProvider', new DummyUploadProvider());
    }

    /**
     * @When I upload :arg1 archive using providers:
     */
    public function iUploadArchiveUsingProviders($archiveName, TableNode $table)
    {
        $providersNames = array_map(
            function ($row) {
                return $row['name'];
            },
            $table->getHash()
        );

        $this->uploadArchiveUseCase->execute(new UploadArchiveRequest($archiveName, $providersNames));
    }

    /**
     * @Then :arg1 archive should be uploaded
     */
    public function archiveShouldBeUploaded($name)
    {
        PHPUnit_Framework_Assert::assertEquals($name, $this->lastUploadedArchiveName);
    }

    /**
     * @param string $name
     * @return void
     */
    public function archiveUploaded($name)
    {
        $this->lastUploadedArchiveName = $name;
    }

    /**
     * @param string $name
     * @return void
     */
    public function archiveNotFound($name)
    {
        throw new \LogicException(sprintf('%s archive not found', $name));
    }
}
