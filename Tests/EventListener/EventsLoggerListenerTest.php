<?php

namespace Smartbox\Integration\ServiceBusBundle\Tests\EventListener;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Smartbox\Integration\FrameworkBundle\Events\Event;
use Smartbox\Integration\ServiceBusBundle\EventListener\EventsLoggerListener;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class EventsLoggerListenerTest
 * @package Smartbox\Integration\ServiceBusBundle\Tests\EventListener
 */
class EventsLoggerListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var EventsLoggerListener */
    private $listener;

    /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $logger;

    /** @var string */
    private $logLevel = LogLevel::DEBUG;

    public function setUp()
    {
        $this->logger = $this->getMockBuilder(LoggerInterface::class)->getMock();
        /** @var RequestStack $requestStack */
        $requestStack = $this->getMockBuilder(RequestStack::class)->getMock();
        $this->listener = new EventsLoggerListener($this->logger, $requestStack, $this->logLevel);
    }

    public function testItShouldLogEventWhenItOccurs()
    {
        /** @var Event|\PHPUnit_Framework_MockObject_MockObject $dummyEvent */
        $event = $this->getMockForAbstractClass(Event::class);

        $this->logger
            ->expects($this->once())
            ->method('log')
            ->with($this->logLevel, $this->isType('string'), ['event' => $event])
        ;

        $this->listener->onEvent($event);
    }
}
