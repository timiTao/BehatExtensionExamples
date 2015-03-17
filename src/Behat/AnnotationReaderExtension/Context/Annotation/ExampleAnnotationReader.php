<?php
/**
 * User: Tom
 */

namespace Behat\AnnotationReaderExtension\Context\Annotation;

use Behat\Behat\Context\Annotation\AnnotationReader;
use Behat\Behat\Hook\Call\BeforeStep;
use Behat\Behat\Hook\Scope\BeforeStepScope;
use Behat\Testwork\Call\Callee;
use ReflectionMethod;

/**
 * Class ExampleAnnotationReader
 *
 * @package Behat\AnnotationReaderExtension\Context\Annotation
 */
class ExampleAnnotationReader implements AnnotationReader
{
    protected $basePath;

    /**
     * @param $basePath
     */
    function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Reads all callees associated with a provided method.
     *
     * @param string $contextClass
     * @param ReflectionMethod $method
     * @param string $docLine
     * @param string $description
     *
     * @return null|Callee
     */
    public function readCallee($contextClass, ReflectionMethod $method, $docLine, $description)
    {
        if (!strpos($docLine, 'testAnnotation')) {
            return null;
        }

        $basePath = $this->basePath;

        $callback = function (BeforeStepScope $scope) use ($basePath) {
            $file = $scope->getFeature()->getFile();
            $line = $scope->getFeature()->getLine();
            file_put_contents($basePath . '/testAnnotation.txt', sprintf("%s:%s \n", $file, $line));
        };

        return new BeforeStep(null, $callback);
    }

} 