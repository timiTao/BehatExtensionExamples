Feature: Class resolver interface
  In order to use class resolver
  As a feature automator
  I need to be able to use behat class resolver interface

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
            - exampleClassResolver:testFeatureContext
      extensions:
        Behat\ClassResolverExtension\ServiceContainer\Extension: ~
      """
    And a file named "features/bootstrap/FeatureContext.php" with:
    """
      <?php

      use Behat\Behat\Context\Context;

      class FeatureContext implements Context
      {

      }
      """
    And a file named "features/bootstrap/Example/FeatureContext/TestFeatureContext.php" with:
    """
    <?php

    namespace Example\FeatureContext;

    use Behat\Behat\Context\Context;

    class TestFeatureContext implements Context
    {
      /**
       * @Given this scenario step exists
       */
      public function thisScenarioStepExists()
      {

      }
    }
    """
    And a file named "features/feature.feature" with:
    """
      Feature:
        Scenario:
          Given this scenario step exists
      """
    When I run "behat -f progress --no-colors --append-snippets"
    Then it should pass with:
    """
    .

    1 scenario (1 passed)
    1 step (1 passed)
    """
