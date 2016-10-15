ZF2 SuperMessenger module
==============

Version 1.1 Created by [Matthias Büsing](http://mb-tec.eu/)

/!\ This module is now a PR to Zend Framework 3 : https://github.com/zendframework/zf2/pull/3502.
Give me your feedback !

Introduction
------------

ZF3 SuperMessenger module provide new features for plugin FlashMessenger. Now, you can add directly 3 level of messages : 
success message, error message or info message.

Usage
------------

• Usage in controller :

```php
$this->flashMessenger()->addInfoMessage('bar-info');
$this->flashMessenger()->addSuccessMessage('bar-success');
$this->flashMessenger()->addErrorMessage('bar-error');
```
Just active the module and the FlashMessenger will have features without BC ! You can use SuperMessenger by the identifier "FlashMessenger" with the alias.
You could use the identifier "SuperMessenger" to pilot the plugin.

• Usage in view :

And to be complete, there is a view helper. Usage in a view to get list of messages :

```php
<?php
    $infoMessages = $this->flashMessenger('info');
?>
```

You can directly have a render of the messages :

```php
<?php
    echo $this->flashMessenger()->render('info');
?>
```

By default, the format is :

```php
<ul class="info">
    <li>first message</li>
    <li>second message</li>
</ul>
```

You can change the format, like this :

```php
<?php
    echo $this->flashMessenger()
                ->setMessageOpenFormat('<div%s><p>')
                ->setMessageSeparatorString('</p><p>')
                ->setMessageCloseString('</p></div>')
                ->render('info');
?>
```

Format could be changed in supermessenger.local.php which will be moved in "/config/autoload" :

```php
'view_helper' => array(
    'supermessenger' => array(
        'message_open_format' => '<div%s><ul><li>',
        'message_separator_string' => '</li><li>',
        'message_close_string' => '</li></ul></div>',
    ),
),
```

You can change easily the class CSS with :

```php
<?php
    echo $this->flashMessenger()->render('info', array('foo-baz', 'foo-bar'));
?>
```

```php
<ul class="foo-baz foo-bar">
    <li>first message</li>
    <li>second message</li>
</ul>
```