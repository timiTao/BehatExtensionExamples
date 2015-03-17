<?php
/**
 * User: Tom
 */

namespace Behat\ClassResolverExtension\Context\ContextClass;

use Behat\Behat\Context\ContextClass\ClassResolver as BaseClassResolver;

/**
 * Class ExampleClassResolver
 *
 * @package Behat\ClassResolverExtension\Context\ContextClass
 */
class ExampleClassResolver implements BaseClassResolver
{
    /**
     * @param string $contextClass
     * @return bool
     */
    public function supportsClass($contextClass)
    {
        return (strpos($contextClass, 'exampleClassResolver:') === 0);
    }

    /**
     * @param string $contextClass
     * @return string
     */
    public function resolveClass($contextClass)
    {
        list(, $className) = explode(':', $contextClass);
        $className = ucfirst($className);

        return "\\Example\\FeatureContext\\" . $className;
    }

} 