ZF2 SuperMessenger module
==============

Version 1.0 Created by [Vincent Blanchon](http://developpeur-zend-framework.fr/)

Introduction
------------

ZF2 SuperMessenger module provide new feature for plugin FlashMessenger. Now, you can add directly 3 level of messages : 
success message, error message or info message.

Usage
------------

• Usage in controller :

```php
$this->flashMessenger()->addInfoMessage('bar-info');
$this->flashMessenger()->addSuccessMessage('bar-success');
$this->flashMessenger()->addErrorMessage('bar-error');
```
Just active the module and the FlashMessenger will have features without BC !

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

By default, the format is

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