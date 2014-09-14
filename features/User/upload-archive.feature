Feature: Uploading archive
  In order to save my files
  As a user
  I need to upload existing archive

  Scenario: Uploading archive
    Given There is "first" archive
    And I have configured myProvider
    When I upload "first" archive using providers:
      | name       |
      | myProvider |
    Then "first" archive should be uploaded
