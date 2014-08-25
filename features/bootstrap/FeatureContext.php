<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

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
    }

    /**
     * @Given I have a following files:
     */
    public function iHaveAFollowingFiles(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given I have project configured properly
     */
    public function iHaveProjectConfiguredProperly()
    {
        throw new PendingException();
    }

    /**
     * @When I create :arg1 archive from :arg2 directory
     */
    public function iCreateArchiveFromDirectory($arg1, $arg2)
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
