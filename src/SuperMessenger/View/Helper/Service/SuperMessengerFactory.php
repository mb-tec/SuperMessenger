<?php

/*
 * This file is part of the SuperMessenger package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace SuperMessenger\View\Helper\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SuperMessenger\View\Helper\SuperMessenger;

class SuperMessengerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $config = $serviceLocator->get('Config');
        $config = $config['super_messenger'];
        $helper = new SuperMessenger();
        if(isset($config['view']['helper']['message_open_format'])) {
            $helper->setMessageOpenFormat($config['view']['helper']['message_open_format']);
        }
        if(isset($config['view']['helper']['message_separator_string'])) {
            $helper->setMessageSeparatorString($config['view']['helper']['message_separator_string']);
        }
        if(isset($config['view']['helper']['message_close_string'])) {
            $helper->setMessageCloseString($config['view']['helper']['message_close_string']);
        }
        return $helper;
    }
}
