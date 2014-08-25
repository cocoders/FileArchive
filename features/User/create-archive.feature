Feature: Creating archive
  In order to upload file archive
  As a user
  I need to create archive from selected files first

  Scenario: Creating archive
    Given I have a following files:
      | path                      |
      | /home/cocoders/aaa/a.jpg  |
      | /home/cocoders/bbb/b.jpg  |
      | /home/cocoders/bbb/b.wav  |
    And I have project configured properly
    When I create "my-name" archive from "/home/cocoders/bbb/" directory
    Then I should see "my-name" archive on the archives list
    And "my-name" archive should not be uploaded
