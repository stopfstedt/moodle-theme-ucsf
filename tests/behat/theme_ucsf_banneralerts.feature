@theme @theme_ucsf @theme_ucsf_banneralerts
Feature:
  In order stay informed
  As a user
  I should receive banner alert messages on pages

  Scenario: Alert Levels
      Given the following config values are set as admin:
      | enable1alert           | 0         | theme_ucsf |
      | recurring_alert1       | 1         | theme_ucsf |
      | categories_list_alert1 | 0         | theme_ucsf |
      | alert1type             | error     | theme_ucsf |
      | alert1text             | bazbork   | theme_ucsf |
      | enable2alert           | 0         | theme_ucsf |
      | recurring_alert2       | 1         | theme_ucsf |
      | categories_list_alert2 | 0         | theme_ucsf |
      | alert2type             | error     | theme_ucsf |
      | alert2text             | bazbork   | theme_ucsf |

    Given I am on site homepage
