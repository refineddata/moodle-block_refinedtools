@refined_training @block_refinedtools @block @block_browse_reminders
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
    Then I log out
    Given I log in as "admin"
    And I am on homepage
    Then I follow "Browse Reminders"
    And I follow "Add reminder"
    And I press "Cancel"
    And I follow "Home"
    Then I follow "Managers/Locations"
    And I follow "Add a New Location / Manager"
    And I press "Cancel"
    And I follow "Home"
    Then I follow "Add/Edit Tokens"
    And I follow "Add a New Token Batch"
    And I press "Cancel"
    And I follow "Home"
    Then I follow "Role Alerts"
    And I follow "Add Role Alert"
    And I press "Cancel"
    And I follow "Home"
    Then I log out

  @javascript
  Scenario: The list of RefinedTools links is shown
    Given I log in as "admin"
    When I am on homepage
    Then I should see "Launch Adobe Connect" in the "RefinedTools" "block"
    And I should see "Browse Reminders" in the "RefinedTools" "block"
    And I should see "Managers/Locations" in the "RefinedTools" "block"
    And I should see "Add/Edit Tokens" in the "RefinedTools" "block"
    And I should see "Role Alerts" in the "RefinedTools" "block"
    And I should see "Refined Support Center" in the "RefinedTools" "block"
    Then I log out

