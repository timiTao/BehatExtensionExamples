Feature: Transformer interface
  In order to use transformer
  As a feature automator
  I need to be able to use transformer interface

  Scenario: Tests valid transformation
    Given a file named "behat.yml" with:
    """
    default:
      autoload:
        '': %paths.base%/features/bootstrap/
      suites:
        default:
          path: %paths.base%/features
      extensions:
        Behat\TransformerExtension\ServiceContainer\Extension: ~
      """
    And a file named "features/bootstrap/FeatureContext.php" with:
    """
      <?php

      use Behat\Behat\Context\Context;

      class FeatureContext implements Context
      {
        /**
         * @Given information :arg1 will be equal to transformation
         */
         public function informationWillBeEqualTo($arg1)
         {
            if ($arg1 != 'transformation')
            {
              throw new \Exception(sprintf("Tests fails. Argument '%s' is not equal 'phpers'.", $arg1));
            }
         }
      }
      """
    And a file named "features/feature.feature" with:
    """
      Feature:
        Scenario:
          Given information "test" will be equal to transformation
      """
    When I run "behat -f progress --no-colors --append-snippets"
    Then it should pass with:
    """
    .

    1 scenario (1 passed)
    1 step (1 passed)
    """

  Scenario: Tests valid transformation
    Given a file named "behat.yml" with:
    """
    default:
      autoload:
        '': %paths.base%/features/bootstrap/
      suites:
        default:
          path: %paths.base%/features
      extensions:
        Behat\TransformerExtension\ServiceContainer\Extension: ~
      """
    And a file named "features/bootstrap/FeatureContext.php" with:
    """
      <?php

      use Behat\Behat\Context\Context;

      class FeatureContext implements Context
      {
        /**
         * @Given information :arg1 will be equal to transformation
         */
         public function informationWillBeEqualTo($arg1)
         {
            if ($arg1 != 'wrong')
            {
              throw new \Exception(sprintf("Tests fails. Argument '%s' is not equal 'wrong'.", $arg1));
            }
         }
      }
      """
    And a file named "features/feature.feature" with:
    """
      Feature:
        Scenario:
          Given information "test" will be equal to transformation
      """
    When I run "behat -f progress --no-colors --append-snippets"
    Then it should fail
    """
    F

    --- Failed steps:

        Given information "test" will be equal to transformation # features/config.feature:3
          Tests fails. Argument 'transformation' is not equal 'wrong'. (Exception)

    1 scenario (1 failed)
    1 step (1 failed)
    """
