<?php

namespace SuperMessenger;

return [
    'controller_plugins' => [
        'invokables' => [
            'supermessenger' => Controller\Plugin\SuperMessenger::class,
        ],
        'aliases' => [
            'flashmessenger' => 'supermessenger',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'supermessenger' => View\Helper\Service\SuperMessengerFactory::class,
        ],
        'aliases' => [
            'flashmessenger' => 'supermessenger',
        ],
    ],
];
