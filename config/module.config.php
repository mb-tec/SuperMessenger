<?php

namespace SuperMessenger;

return [
    'controller_plugins' => array(
        'invokables' => array(
            'supermessenger' => Controller\Plugin\SuperMessenger::class,
        ),
        'aliases' => array(
            'flashmessenger' => 'supermessenger',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'supermessenger' => View\Helper\Service\SuperMessengerFactory::class,
        ),
        'aliases' => array(
            'flashmessenger' => 'supermessenger',
        ),
    ),
];
