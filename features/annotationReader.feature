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
      extensions:
        Behat\AnnotationReaderExtension\ServiceContainer\Extension: ~
      """
    And a file named "features/bootstrap/FeatureContext.php" with:
    """
      <?php

      use Behat\Behat\Context\Context;

      class FeatureContext implements Context
      {

        /**
         * @Given context argument should have :arg1
         * @testAnnotation
         */
        public function thisScenarioStepExists($arg1)
        {

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
    And file "/testAnnotation.txt" should exist
