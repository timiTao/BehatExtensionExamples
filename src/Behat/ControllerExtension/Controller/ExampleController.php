<?php
/**
 * @author Tomasz Kunicki
 */
namespace Behat\ControllerExtension\Controller;


use Behat\Testwork\Cli\Controller;
use Behat\Testwork\EventDispatcher\Event\AfterSuiteTested;
use Behat\Testwork\EventDispatcher\Event\BeforeSuiteTested;
use Behat\Testwork\EventDispatcher\Event\SuiteTested;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ExampleController
 *
 * @package Behat\ControllerExtension\Controller
 */
class ExampleController implements Controller
{
    protected $startTime;

    protected $basePath;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param $basePath
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, $basePath)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->basePath = $basePath;
    }

    /**
     * Configures command to be executable by the controller.
     *
     * @param SymfonyCommand $command
     */
    public function configure(SymfonyCommand $command)
    {
        $command->addOption(
            '--real-time',
            null,
            InputOption::VALUE_NONE,
            'Show real time execution of tests'
        );
    }

    /**
     * Executes controller.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|integer
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getOption('real-time')) {
            return;
        }
        $this->eventDispatcher->addListener(SuiteTested::BEFORE, array($this, 'startCountTime'), -50);
        $this->eventDispatcher->addListener(SuiteTested::AFTER, array($this, 'finishCountTime'), -50);
    }

    /**
     * @param BeforeSuiteTested $event
     */
    public function startCountTime(BeforeSuiteTested $event)
    {
        $this->startTime = microtime(true);
    }

    /**
     * @param AfterSuiteTested $event
     */
    public function finishCountTime(AfterSuiteTested $event)
    {
        $stopTime = microtime(true);

        $totalTime = bcsub($stopTime, $this->startTime, 2);
        $str = $this->basePath . "/controllerTime.txt";
        file_put_contents($str, $totalTime);
    }

}
