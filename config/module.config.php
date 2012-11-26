<?php

return array(
    'controller_plugins' => array(
        'invokables' => array(
            'supermessenger' => 'SuperMessenger\Controller\Plugin\SuperMessenger',
        ),
        'aliases' => array(
            'flashmessenger' => 'supermessenger',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'supermessenger' => 'SuperMessenger\View\Helper\SuperMessenger',
        ),
        'aliases' => array(
            'flashmessenger' => 'supermessenger',
        ),
    ),
);
