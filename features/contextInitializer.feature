Feature: Context initializer interface
  In order to use context initializer
  As a feature automator
  I need to be able to use behat context initializer interface

  Scenario: Tests controller
    Given a file named "behat.yml" with:
    """
    default:
      autoload:
        '': %paths.base%/features/bootstrap/
      suites:
        default:
          path: %paths.base%/features
      extensions:
        Behat\ContextInitializerExtension\ServiceContainer\Extension: ~
      """
    And a file named "features/bootstrap/FeatureContext.php" with:
    """
      <?php

      use Behat\Behat\Context\Context;

      class FeatureContext implements Context
      {
        protected $initializerText;

        public function setInitializerText($text)
        {
          $this->initializerText = $text;
        }

        /**
         * @Given information :arg1 will be equal to initializer text
         */
         public function informationWillBeEqualTo($arg1)
         {
            if ($arg1 != $this->initializerText)
            {
              throw new \Exception(sprintf("Tests fails. Argument '%s' is not equal '%s'.", $arg1, $this->initializerText));
            }
         }
      }
      """
    And a file named "features/feature.feature" with:
    """
      Feature:
        Scenario:
          Given information "myInitializerText" will be equal to initializer text
      """
    When I run "behat -f progress --no-colors --append-snippets"
    Then it should pass with:
    """
    .

    1 scenario (1 passed)
    1 step (1 passed)
    """
