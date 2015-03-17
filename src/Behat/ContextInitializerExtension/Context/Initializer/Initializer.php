<?php
/**
 * User: Tom
 */

namespace Behat\ContextInitializerExtension\Context\Initializer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;

/**
 * Class Initializer
 *
 * @package Behat\ContextInitializerExtension\Context\Initializer
 */
class Initializer implements ContextInitializer
{
    /**
     * @var string
     */
    protected $initializerText;

    /**
     * @param $initializerText
     */
    function __construct($initializerText)
    {
        $this->initializerText = $initializerText;
    }

    /**
     * @param Context $context
     */
    public function initializeContext(Context $context)
    {
        $context->setInitializerText($this->initializerText);
    }

}
