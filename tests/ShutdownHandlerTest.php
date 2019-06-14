<?php
/**
 * Definition of ShutdownHandlerTest
 *
 * @author Marco Stoll <marco@fast-forward-encoding.de>
 * @copyright 2019-forever Marco Stoll
 * @filesource
 */
declare(strict_types=1);

namespace FF\Tests\Runtime;

use FF\Events\EventBroker;
use FF\Runtime\Events\OnShutdown;
use FF\Runtime\ShutdownHandler;
use PHPUnit\Framework\TestCase;

/**
 * Test ShutdownHandlerTest
 *
 * @package FF\Tests
 */
class ShutdownHandlerTest extends TestCase
{
    /**
     * @var ShutdownHandler
     */
    protected $uut;

    /**
     * @var OnShutdown
     */
    protected static $lastEvent;

    /**
     * {@inheritdoc}
     */
    public static function setUpBeforeClass(): void
    {
        // register test listener
        EventBroker::getInstance()->subscribe([__CLASS__, 'listener'], 'Runtime\OnShutdown');
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->uut = new ShutdownHandler();
        self::$lastEvent = null;
    }

    /**
     * @param OnShutdown $event
     */
    public static function listener(OnShutdown $event)
    {
        self::$lastEvent = $event;
    }

    /**
     * Dummy callback
     */
    public function dummyHandler()
    {
        $this->fail('dummy handler should never be called');
    }

    /**
     * Tests the namesake method/feature
     */
    public function testSetGetForceExit()
    {
        $same = $this->uut->setForceExit(false);
        $this->assertSame($this->uut, $same);
        $this->assertFalse($this->uut->getForceExit());
    }

    /**
     * Tests the namesake method/feature
     */
    public function testRegister()
    {
        $same = $this->uut->register();
        $this->assertSame($this->uut, $same);
    }

    /**
     * Tests the namesake method/feature
     */
    public function testTriggerShutdownHandling()
    {
        $this->uut->register()
            ->onShutdown();

        $this->assertNotNull(self::$lastEvent);
    }
}