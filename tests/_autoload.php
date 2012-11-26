<?php

require_once __DIR__ . '/../../zf2/library/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array(
    'Zend\Loader\StandardAutoloader' => array(
        'autoregister_zf' => true,
        'namespaces' => array(
            'SuperMessenger' => __DIR__ . '/../src/SuperMessenger',
            'SuperMessengerTest' => __DIR__ . '/SuperMessenger',
            'ZendTest' => __DIR__ . '/ZendTest',
        ),
    ),
));