<?php

return array(
    'super_messenger' => array(
        'view' => array(
            'helper' => array(
                // define here the message format
            ),
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'supermessenger' => 'SuperMessenger\Controller\Plugin\SuperMessenger',
        ),
        'aliases' => array(
            'flashmessenger' => 'supermessenger',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'supermessenger' => 'SuperMessenger\View\Helper\Service\SuperMessengerFactory',
        ),
        'aliases' => array(
            'flashmessenger' => 'supermessenger',
        ),
    ),
);
