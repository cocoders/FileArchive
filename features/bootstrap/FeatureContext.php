<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Cocoders\DummyFileSource\DummyFileSource;
use Cocoders\FileSource\FileSourceRegistry;

/**
 * Behat context class.
 */
class FeatureContext implements SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets it's own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->fileSourceRegistry = new FileSourceRegistry();
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
    public function iCreateArchiveFromDirectoryUsingFilesource($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see :arg1 archive on the archives list
     */
    public function iShouldSeeArchiveOnTheArchivesList($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given :arg1 archive should not be uploaded
     */
    public function archiveShouldNotBeUploaded($arg1)
    {
        throw new PendingException();
    }
}
