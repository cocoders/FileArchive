Feature: Creating archive
  In order to upload file archive
  As a user
  I need to create archive from selected files first

  Scenario: Creating archive
    Given There is dummy file source with following files:
      | path                      |
      | /home/cocoders/aaa/a.jpg  |
      | /home/cocoders/bbb/b.jpg  |
      | /home/cocoders/bbb/b.wav  |
    When I create "my-name" archive from "/home/cocoders/bbb/" directory using "dummy" file source
    Then I should see "my-name" archive on the archives list
