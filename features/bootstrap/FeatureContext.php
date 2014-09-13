<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Cocoders\Archive\InMemoryArchive\InMemoryArchiveFactory;
use Cocoders\Archive\InMemoryArchive\InMemoryArchiveRepository;
use Cocoders\UseCase\CreateArchive\CreateArchiveRequest;
use Cocoders\UseCase\CreateArchive\CreateArchiveUseCase;
use Cocoders\FileSource\DummyFileSource\DummyFileSource;
use Cocoders\FileSource\InMemoryFileSource\InMemoryFileSourceRegistry;

class FeatureContext implements SnippetAcceptingContext
{
    public function __construct()
    {
        $this->fileSourceRegistry = new InMemoryFileSourceRegistry();
        $this->archiveRepository = new InMemoryArchiveRepository();
        $this->archiveFactory = new InMemoryArchiveFactory();
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
        $createArchiveRequest = new CreateArchiveRequest($fileSourceName, $archiveName, $path);

        $createArchiveUseCase = new CreateArchiveUseCase(
            $this->fileSourceRegistry,
            $this->archiveFactory,
            $this->archiveRepository
        );

        $createArchiveUseCase->execute($createArchiveRequest);
    }

    /**
     * @Then I should see :arg1 archive on the archives list
     */
    public function iShouldSeeArchiveOnTheArchivesList($name)
    {
        PHPUnit_Framework_Assert::assertEquals($name, $this->archiveRepository->findByName($name)->getName());
    }
}
