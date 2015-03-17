Feature: Class context argument resolver
  In order to use class context argument resolver
  As a feature automator
  I need to be able to use behat class context argument resolver

  Scenario: Tests controller
    Given a file named "behat.yml" with:
    """
    default:
      autoload:
        '': %paths.base%/features/bootstrap/
      suites:
        default:
          path: %paths.base%/features
          contexts:
            - \FeatureContext:
              - Test
      extensions:
        Behat\ContextArgumentResolverExtension\ServiceContainer\Extension: ~
      """
    And a file named "features/bootstrap/FeatureContext.php" with:
    """
      <?php

      use Behat\Behat\Context\Context;

      class FeatureContext implements Context
      {
        protected $text;

        public function __construct($string)
        {
          $this->text = $string;
        }

        /**
         * @Given context argument should have :arg1
         */
        public function thisScenarioStepExists($arg1)
        {
            if ($arg1 != $this->text)
            {
              throw new \Exception(sprintf("Tests fails. Argument '%s' is not equal '%s'.", $arg1, $this->text));
            }
        }
      }
    """
    And a file named "features/feature.feature" with:
    """
      Feature:
        Scenario:
          Given context argument should have "ArgumentTestArgument"
      """
    When I run "behat -f progress --no-colors --append-snippets"
    Then it should pass with:
    """
    .

    1 scenario (1 passed)
    1 step (1 passed)
    """
