<?php

return array(
    'view_helper' => array(
        'supermessenger' => array(
            'message_open_format' => '<div%s><ul><li>',
            'message_separator_string' => '</li><li>',
            'message_close_string' => '</li></ul></div>',
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
