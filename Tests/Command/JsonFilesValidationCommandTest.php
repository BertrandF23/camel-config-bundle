<?php

namespace Smartbox\Integration\ServiceBusBundle\Tests\Command;

use Smartbox\Integration\ServiceBusBundle\Command\JsonFilesValidationCommand;
use Smartbox\Integration\ServiceBusBundle\Tests\BaseKernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class JsonFilesValidationCommandTest
 * @package Smartbox\Integration\ServiceBusBundle\Tests\Unit\Command
 */
class JsonFilesValidationCommandTest extends BaseKernelTestCase
{
    public function testExecuteForSuccessOutput()
    {
        $application = new Application(self::$kernel);
        $application->add(new JsonFilesValidationCommand());

        $command = $application->find('smartbox:validate:json');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName(),
            'path'         => '@SmartboxIntegrationFrameworkBundle/Tests/Unit/Command/fixtures/success',
        ));

        $this->assertRegExp('/Everything is OK./', $commandTester->getDisplay());
    }

    public function testExecuteForFailureOutput()
    {
        $application = new Application(self::$kernel);
        $application->add(new JsonFilesValidationCommand());

        $path = '@SmartboxIntegrationFrameworkBundle/Tests/Unit/Command/fixtures/failure';

        $command = $application->find('smartbox:validate:json');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName(),
            'path'         => $path,
        ));

        $this->assertRegExp(
            sprintf(
                '/Some fixture files in "%s" directory have invalid format./',
                '@SmartboxIntegrationFrameworkBundle\/Tests\/Unit\/Command\/fixtures\/failure'
            ),
            $commandTester->getDisplay()
        );
    }
}