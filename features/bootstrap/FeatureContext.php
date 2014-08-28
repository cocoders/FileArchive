<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Cocoders\Archive\InMemoryArchiveFactory;
use Cocoders\Archive\InMemoryArchiveRepository;
use Cocoders\CreateArchive\CreateArchiveRequest;
use Cocoders\CreateArchive\CreateArchiveResponder;
use Cocoders\CreateArchive\CreateArchiveUseCase;
use Cocoders\DummyFileSource\DummyFileSource;
use Cocoders\FileSource\InMemoryFileSourceRegistry;

/**
 * Behat context class.
 */
class FeatureContext implements SnippetAcceptingContext, CreateArchiveResponder
{
    /**
     * Initializes context.
     *
     * Every scenario gets it's own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->fileSourceRegistry = new InMemoryFileSourceRegistry();
        $this->archiveRepository = new InMemoryArchiveRepository();
        $this->archiveFactory = new InMemoryArchiveFactory();

        $this->lastAddedArchiveName = false;
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
    public function iCreateArchiveFromDirectoryUsingFilesource($name, $path, $fileSource)
    {
        $createArchiveRequest = new CreateArchiveRequest($fileSource, $name, $path);

        $createArchiveUseCase = new CreateArchiveUseCase(
            $this->fileSourceRegistry,
            $this->archiveFactory,
            $this->archiveRepository
        );

        $createArchiveUseCase->addResponder($this);
        $createArchiveUseCase->execute($createArchiveRequest);
    }

    /**
     * @Then I should see :arg1 archive on the archives list
     */
    public function iShouldSeeArchiveOnTheArchivesList($name)
    {
        PHPUnit_Framework_Assert::assertEquals($name, $this->lastAddedArchiveName);
    }

    /**
     * @Given :arg1 archive should not be uploaded
     */
    public function archiveShouldNotBeUploaded($arg1)
    {
        throw new PendingException();
    }

    public function archiveCreated($name)
    {
        $this->lastAddedArchiveName = $name;
    }
}
