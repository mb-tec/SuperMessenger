<?php

/*
 * This file is part of the SuperMessenger package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace SuperMessengerTest\Controller\Plugin;

use SuperMessenger\Controller\Plugin\SuperMessenger;
use ZendTest\Session\TestAsset\TestManager as SessionManager;

class SuperMessengerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SuperMessenger
     */
    protected $helper;

    public function setUp()
    {
        $this->session = new SessionManager();
        $this->helper  = new SuperMessenger();
        $this->helper->setSessionManager($this->session);
    }

    public function seedMessages()
    {
        $helper = new SuperMessenger();
        $helper->setSessionManager($this->session);
        $helper->addMessage('foo');
        $helper->addMessage('bar');
        $helper->addInfoMessage('bar-info');
        $helper->addSuccessMessage('bar-success');
        $helper->addErrorMessage('bar-error');
        unset($helper);
    }

    public function testComposesSessionManagerByDefault()
    {
        $helper  = new SuperMessenger();
        $session = $helper->getSessionManager();
        $this->assertEquals('Zend\Session\SessionManager', get_class($session));
    }

    public function testSessionManagerIsMutable()
    {
        $session = new SessionManager();
        $this->helper->setSessionManager($session);
        $this->assertSame($session, $this->helper->getSessionManager());
    }

    public function testUsesContainerNamedAfterClass()
    {
        $container = $this->helper->getContainer();
        $this->assertEquals('SuperMessenger', $container->getName());
    }

    public function testUsesNamespaceNamedDefaultWithNoConfiguration()
    {
        $this->assertEquals('default', $this->helper->getNamespace());
    }

    public function testNamespaceIsMutable()
    {
        $this->helper->setNamespace('foo');
        $this->assertEquals('foo', $this->helper->getNamespace());
    }

    public function testMessengerIsEmptyByDefault()
    {
        $this->assertFalse($this->helper->hasMessages());
    }

    public function testCanAddMessages()
    {
        $this->helper->addMessage('foo');
        $this->assertTrue($this->helper->hasCurrentMessages());
    }

    public function testAddingMessagesDoesNotChangeCount()
    {
        $this->assertEquals(0, count($this->helper));
        $this->helper->addMessage('foo');
        $this->assertEquals(0, count($this->helper));
    }

    public function testCanClearMessages()
    {
        $this->seedMessages();
        $this->assertTrue($this->helper->hasMessages());
        $this->assertTrue($this->helper->hasInfoMessages());
        $this->assertTrue($this->helper->hasSuccessMessages());
        $this->assertTrue($this->helper->hasErrorMessages());

        $this->helper->clearMessages();
        $this->assertFalse($this->helper->hasMessages());
        $this->assertTrue($this->helper->hasInfoMessages());
        $this->assertTrue($this->helper->hasSuccessMessages());
        $this->assertTrue($this->helper->hasErrorMessages());

        $this->helper->clearMessagesFromNamespace(SuperMessenger::INFO_MESSAGE);
        $this->assertFalse($this->helper->hasInfoMessages());

        $this->helper->clearMessagesFromContainer();
        $this->assertFalse($this->helper->hasMessages());
        $this->assertFalse($this->helper->hasInfoMessages());
        $this->assertFalse($this->helper->hasSuccessMessages());
        $this->assertFalse($this->helper->hasErrorMessages());
    }

    public function testCanRetrieveMessages()
    {
        $this->seedMessages();
        $this->assertTrue($this->helper->hasMessages());
        $messages = $this->helper->getMessages();
        $this->assertEquals(2, count($messages));
        $this->assertContains('foo', $messages);
        $this->assertContains('bar', $messages);

        $messages = $this->helper->getInfoMessages();
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-info', $messages);

        $messages = $this->helper->getMessagesFromNamespace(SuperMessenger::INFO_MESSAGE);
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-info', $messages);

        $messages = $this->helper->getSuccessMessages();
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-success', $messages);

        $messages = $this->helper->getMessagesFromNamespace(SuperMessenger::SUCCESS_MESSAGE);
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-success', $messages);

        $messages = $this->helper->getErrorMessages();
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-error', $messages);

        $messages = $this->helper->getMessagesFromNamespace(SuperMessenger::ERROR_MESSAGE);
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-error', $messages);
    }

    public function testCanRetrieveCurrentMessages()
    {
        $this->seedMessages();
        $messages = $this->helper->getCurrentMessages();
        $this->assertEquals(2, count($messages));
        $this->assertContains('foo', $messages);
        $this->assertContains('bar', $messages);

        $messages = $this->helper->getCurrentInfoMessages();
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-info', $messages);

        $messages = $this->helper->getCurrentMessagesFromNamespace(SuperMessenger::INFO_MESSAGE);
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-info', $messages);

        $messages = $this->helper->getCurrentSuccessMessages();
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-success', $messages);

        $messages = $this->helper->getCurrentMessagesFromNamespace(SuperMessenger::SUCCESS_MESSAGE);
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-success', $messages);

        $messages = $this->helper->getCurrentErrorMessages();
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-error', $messages);

        $messages = $this->helper->getCurrentMessagesFromNamespace(SuperMessenger::ERROR_MESSAGE);
        $this->assertEquals(1, count($messages));
        $this->assertContains('bar-error', $messages);
    }

    public function testCanClearCurrentMessages()
    {
        $this->helper->addMessage('foo');
        $this->assertTrue($this->helper->hasCurrentMessages());
        $this->helper->clearCurrentMessages();
        $this->assertFalse($this->helper->hasCurrentMessages());

        $this->seedMessages();
        $this->assertTrue($this->helper->hasCurrentMessages());
        $this->assertTrue($this->helper->hasCurrentInfoMessages());
        $this->assertTrue($this->helper->hasCurrentSuccessMessages());
        $this->assertTrue($this->helper->hasCurrentErrorMessages());

        $this->helper->clearCurrentMessages();
        $this->assertFalse($this->helper->hasCurrentMessages());
        $this->assertTrue($this->helper->hasCurrentInfoMessages());
        $this->assertTrue($this->helper->hasCurrentSuccessMessages());
        $this->assertTrue($this->helper->hasCurrentErrorMessages());

        $this->helper->clearCurrentMessagesFromNamespace(SuperMessenger::INFO_MESSAGE);
        $this->assertFalse($this->helper->hasCurrentInfoMessages());

        $this->helper->clearCurrentMessagesFromContainer();
        $this->assertFalse($this->helper->hasCurrentMessages());
        $this->assertFalse($this->helper->hasCurrentInfoMessages());
        $this->assertFalse($this->helper->hasCurrentSuccessMessages());
        $this->assertFalse($this->helper->hasCurrentErrorMessages());
    }

    public function testIterationOccursOverMessages()
    {
        $this->seedMessages();
        $test = array();
        foreach ($this->helper as $message) {
            $test[] = $message;
        }
        $this->assertEquals(array('foo', 'bar'), $test);
    }

    public function testCountIsOfMessages()
    {
        $this->seedMessages();
        $this->assertEquals(2, count($this->helper));
    }
}
