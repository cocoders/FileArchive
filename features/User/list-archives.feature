Feature: Creating archive
  In order to select archive to upload
  As a user
  I need to list archives

  Background:
    Given there is such archives:
      | name   |
      | first  |
      | second |
    And I have configured myProvider
    When I upload "first" archive using providers:
      | name       |
      | myProvider |

  Scenario: List archives
    When I am listing archives
    Then I should see such archives:
      | name   | uploaded |
      | first  |        1 |
      | second |        0 |

