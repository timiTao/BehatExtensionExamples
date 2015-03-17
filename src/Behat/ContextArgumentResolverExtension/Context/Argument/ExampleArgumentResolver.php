<?php
/**
 * User: Tom
 */

namespace Behat\ContextArgumentResolverExtension\Context\Argument;

use Behat\Behat\Context\Argument\ArgumentResolver;
use ReflectionClass;

/**
 * Class ExampleArgumentResolver
 *
 * @package Behat\ContextArgumentResolverExtension\Context\Argument
 */
class ExampleArgumentResolver implements ArgumentResolver
{
    /**
     * Resolves context constructor arguments.
     *
     * @param ReflectionClass $classReflection
     * @param mixed[] $arguments
     *
     * @return mixed[]
     */
    public function resolveArguments(ReflectionClass $classReflection, array $arguments)
    {
        foreach ($arguments as $key => $value) {
            $arguments[$key] = sprintf("Argument%sArgument", $value);
        }
        
        return $arguments;
    }
}
