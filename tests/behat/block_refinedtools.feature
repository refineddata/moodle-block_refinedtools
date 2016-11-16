@refined_training @block @block_refinedtools
Feature: RefinedTools
  In order to navigate to RefinedTools features
  As an admin
  I need to view navigation links in RefinedTools block

  Background:
    Given I log in as "admin"
    And I am on homepage
    When I follow "Turn editing on"
    And I add the "RefinedTools" block
    Then I should see "RefinedTools"
    And I am on homepage
    And I log out

  @javascript
  Scenario: The list of RefinedTools links is shown
    Given I log in as "admin"
    When I am on homepage
    Then I should see "Launch Adobe Connect" in the "RefinedTools" "block"
    And I should see "Browse Reminders" in the "RefinedTools" "block"

