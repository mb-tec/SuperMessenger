<?php

/*
 * This file is part of the SuperMessenger package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace SuperMessenger\View\Helper\Service;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use SuperMessenger\View\Helper\SuperMessenger;

class SuperMessengerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param                    $requestedName
     * @param array|null         $options
     *
     * @return SuperMessenger
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $helper = new SuperMessenger();
        $controllerPluginManager = $container->get('ControllerPluginManager');
        $flashMessenger = $controllerPluginManager->get('supermessenger');
        $helper->setPluginFlashMessenger($flashMessenger);
        $config = $container->get('Config');

        if (isset($config['supermessenger']['view_helper'])) {
            $configHelper = $config['supermessenger']['view_helper'];

            if (isset($configHelper['message_open_format'])) {
                $helper->setMessageOpenFormat($configHelper['message_open_format']);
            }

            if (isset($configHelper['message_separator_string'])) {
                $helper->setMessageSeparatorString($configHelper['message_separator_string']);
            }

            if (isset($configHelper['message_close_string'])) {
                $helper->setMessageCloseString($configHelper['message_close_string']);
            }
        }

        return $helper;
    }
}
