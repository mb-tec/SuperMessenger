<?php

/*
 * This file is part of the SuperMessenger package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace SuperMessengerTest\View\Helper;

use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;
use Zend\View\HelperPluginManager;
use SuperMessenger\Controller\Plugin\SuperMessenger;
use ZendTest\Session\TestAsset\TestManager as SessionManager;

class SuperMessengerTest extends \PHPUnit_Framework_TestCase
{
    protected $session;

    /**
     * @var SuperMessenger\View\Helper\SuperMessenger
     */
    protected $controllerPluginFlashMessenger;

    /**
     * @var SuperMessenger\View\Helper\SuperMessenger
     */
    protected $viewHelperFlashMessenger;

    public function setUp()
    {
        $this->session = new SessionManager();

        $config = include __DIR__ . '/../../../../config/module.config.php';
        $helperPluginManager = new HelperPluginManager(new Config($config['view_helpers']));
        $controllerPluginManager = new PluginManager(new Config($config['controller_plugins']));

        $sm = new ServiceManager();
        $sm->setService('ControllerPluginManager', $controllerPluginManager);
        $helperPluginManager->setServiceLocator($sm);
        $controllerPluginManager->setServiceLocator($sm);

        $this->controllerPluginFlashMessenger = $controllerPluginManager->get('flashmessenger');
        $this->controllerPluginFlashMessenger->setSessionManager($this->session);
        $this->viewHelperFlashMessenger = $helperPluginManager->get('flashmessenger');
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

    public function testCanAssertPluginClass()
    {
        $this->assertEquals(
            'SuperMessenger\Controller\Plugin\SuperMessenger',
            get_class($this->controllerPluginFlashMessenger)
        );
        $this->assertEquals(
            'SuperMessenger\Controller\Plugin\SuperMessenger',
            get_class($this->viewHelperFlashMessenger->getControllerPluginFlashMessenger())
        );
        $this->assertSame(
            $this->controllerPluginFlashMessenger,
            $this->viewHelperFlashMessenger->getControllerPluginFlashMessenger()
        );
    }

    public function testCanRetrieveMessagesFromPluginController()
    {
        $viewHelperFlashMessenger = $this->viewHelperFlashMessenger;

        $this->assertFalse($viewHelperFlashMessenger()->hasMessages());
        $this->assertFalse($viewHelperFlashMessenger()->hasInfoMessages());
        $this->assertFalse($viewHelperFlashMessenger()->hasSuccessMessages());
        $this->assertFalse($viewHelperFlashMessenger()->hasErrorMessages());

        $this->seedMessages();

        $this->assertTrue($this->controllerPluginFlashMessenger->hasMessages());
        $this->assertTrue($viewHelperFlashMessenger()->hasInfoMessages());
        $this->assertTrue($viewHelperFlashMessenger()->hasSuccessMessages());
        $this->assertTrue($viewHelperFlashMessenger()->hasErrorMessages());
    }

    public function testCanProxyAndRetrieveMessagesFromPluginController()
    {
        $this->assertFalse($this->viewHelperFlashMessenger->hasMessages());
        $this->assertFalse($this->viewHelperFlashMessenger->hasInfoMessages());
        $this->assertFalse($this->viewHelperFlashMessenger->hasSuccessMessages());
        $this->assertFalse($this->viewHelperFlashMessenger->hasErrorMessages());

        $this->seedMessages();

        $this->assertTrue($this->viewHelperFlashMessenger->hasMessages());
        $this->assertTrue($this->viewHelperFlashMessenger->hasInfoMessages());
        $this->assertTrue($this->viewHelperFlashMessenger->hasSuccessMessages());
        $this->assertTrue($this->viewHelperFlashMessenger->hasErrorMessages());
    }

    public function testCanDisplayListOfMessages()
    {
        $displayInfoAssertion = '';
        $displayInfo = $this->viewHelperFlashMessenger->render(SuperMessenger::INFO_MESSAGE);
        $this->assertEquals($displayInfoAssertion, $displayInfo);

        $this->seedMessages();

        $displayInfoAssertion = '<ul class="info"><li>bar-info</li></ul>';
        $displayInfo = $this->viewHelperFlashMessenger->render(SuperMessenger::INFO_MESSAGE);
        $this->assertEquals($displayInfoAssertion, $displayInfo);
    }

    public function testCanDisplayListOfMessagesCustomised()
    {
        $this->seedMessages();

        $displayInfoAssertion = '<div class="foo-baz foo-bar"><p>bar-info</p></div>';
        $displayInfo = $this->viewHelperFlashMessenger
                ->setMessageOpenFormat('<div%s><p>')
                ->setMessageSeparatorString('</p><p>')
                ->setMessageCloseString('</p></div>')
                ->render(SuperMessenger::INFO_MESSAGE, array('foo-baz', 'foo-bar'));
        $this->assertEquals($displayInfoAssertion, $displayInfo);
    }
}
