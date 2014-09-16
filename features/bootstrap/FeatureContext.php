<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Cocoders\Archive\InMemoryArchive\InMemoryArchiveFactory;
use Cocoders\Archive\InMemoryArchive\InMemoryArchiveRepository;
use Cocoders\Upload\UploadedArchive\InMemoryUploadedArchive\InMemoryUploadedArchiveFactory;
use Cocoders\Upload\UploadProvider\DummyUploadProvider\DummyUploadProvider;
use Cocoders\Upload\UploadProvider\InMemoryUploadProvider\InMemoryUploadProvider;
use Cocoders\UseCase\ArchiveList\ArchiveListResponder;
use Cocoders\UseCase\ArchiveList\ArchiveListResponse;
use Cocoders\UseCase\ArchiveList\ArchiveListUseCase;
use Cocoders\UseCase\CreateArchive\CreateArchiveRequest;
use Cocoders\UseCase\CreateArchive\CreateArchiveUseCase;
use Cocoders\FileSource\DummyFileSource\DummyFileSource;
use Cocoders\FileSource\InMemoryFileSource\InMemoryFileSourceRegistry;
use Cocoders\UseCase\UploadArchive\UploadArchiveRequest;
use Cocoders\UseCase\UploadArchive\UploadArchiveResponder;
use Cocoders\UseCase\UploadArchive\UploadArchiveUseCase;

class FeatureContext implements SnippetAcceptingContext, UploadArchiveResponder, ArchiveListResponder
{
    public function __construct()
    {
        $this->lastUploadedArchiveName = null;
        $this->fileSourceRegistry = new InMemoryFileSourceRegistry();
        $this->archiveRepository = new InMemoryArchiveRepository();
        $this->archiveFactory = new InMemoryArchiveFactory();
        $this->uploadedArchiveFactory = new InMemoryUploadedArchiveFactory();
        $this->uploadProvidersRegistry = new InMemoryUploadProvider();
        $this->archiveListUseCase = new ArchiveListUseCase(
            $this->archiveRepository
        );
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
        $this->archiveListUseCase->addResponder($this);
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
        $this->fileSourceRegistry->registerFileSource('dummy', $dummyFileSource);
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
        $this->fileSourceRegistry->registerFileSource('dummy', $dummyFileSource);

        $this->iCreateArchiveFromDirectoryUsingFilesource($archiveName, '/home/cocoders/aaa/', 'dummy');
    }

    /**
     * @Given I have configured myProvider
     */
    public function iHaveConfiguredMyprovider()
    {
        $this->uploadProvidersRegistry->registerUploadProvider('myProvider', new DummyUploadProvider());
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
     * @Given there are such archives:
     */
    public function thereIsSuchArchives(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $this->thereIsArchive($row['name']);
        }
    }

    /**
     * @When I am listing archives
     */
    public function iAmListingArchives()
    {
        $this->archiveListUseCase->execute();
    }

    /**
     * @Then I should see such archives:
     */
    public function iShouldSeeSuchArchives(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $found = array_filter($this->lastArchiveList->items, function ($item) use ($row) {
                return $item->archiveName == $row['name'] && $item->uploaded == (boolean) $row['uploaded'];
            });

            if (!$found) {
                throw new \Exception(sprintf('Archive %s is not found', $row['name']));
            }
        }
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

    public function archiveListFechted(ArchiveListResponse $archiveListResponse)
    {
        $this->lastArchiveList = $archiveListResponse;
    }
}
