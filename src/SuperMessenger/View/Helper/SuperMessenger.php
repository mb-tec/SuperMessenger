<?php

/*
 * This file is part of the SuperMessenger package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace SuperMessenger\View\Helper;

use SuperMessenger\Controller\Plugin\SuperMessenger as PluginSuperMessenger;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;

class SuperMessenger extends AbstractHelper
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**@+
     * @var string Templates for the open/close/separators for message tags
     */
    protected $messageCloseString = '</li></ul>';
    protected $messageOpenFormat = '<ul%s><li>';
    protected $messageSeparatorString = '</li><li>';

    /**
     * @var EscapeHtml
     */
    protected $escapeHtmlHelper;

    /**
     * @var PluginSuperMessenger
     */
    protected $pluginFlashMessenger;

    /**
     * @var array Default attributes for the open format tag
     */
    protected $classMessages = array(
        PluginSuperMessenger::INFO_MESSAGE => 'info',
        PluginSuperMessenger::ERROR_MESSAGE => 'error',
        PluginSuperMessenger::SUCCESS_MESSAGE => 'success',
        PluginSuperMessenger::DEFAULT_MESSAGE => 'default',
    );

    /**
     * Returns the flash messenger plugin controller
     * @return SuperMessenger|SuperMessenger\Controller\Plugin\SuperMessenger
     */
    public function __invoke($namespace = null)
    {
        if (null === $namespace) {
            return $this;
        }
        $flashMessenger = $this->getPluginFlashMessenger();
        $messages = array_merge(
            $flashMessenger->getMessagesFromNamespace($namespace),
            $flashMessenger->getCurrentMessagesFromNamespace($namespace)
        );

        return $messages;
    }

    /**
     * Proxy the flash messenger plugin controller
     *
     * @param string $method
     * @param array  $argv
     *
     * @return mixed
     */
    public function __call($method, $argv)
    {
        $flashMessenger = $this->getPluginFlashMessenger();

        return call_user_func_array(array($flashMessenger, $method), $argv);
    }

    /**
     * @param null  $namespace
     * @param array $classes
     *
     * @return string
     */
    public function render($namespace = null, array $classes = [])
    {
        $flashMessenger = $this->getPluginFlashMessenger();
        $messages = array_merge(
            $flashMessenger->getMessagesFromNamespace($namespace),
            $flashMessenger->getCurrentMessagesFromNamespace($namespace)
        );

        $flashMessenger->clearCurrentMessagesFromNamespace($namespace);

        // Prepare classes for opening tag
        if (empty($classes)) {
            $classes = isset($this->classMessages[$namespace]) ?
                $this->classMessages[$namespace] : $this->classMessages[PluginFlashMessenger::DEFAULT_MESSAGE];
            $classes = array($classes);
        }

        // Flatten message array
        $escapeHtml = $this->getEscapeHtmlHelper();
        $messagesToPrint = array();
        array_walk_recursive($messages, function ($item) use (&$messagesToPrint, $escapeHtml) {
            $messagesToPrint[] = $escapeHtml($item);
        });

        if (empty($messagesToPrint)) {
            return '';
        }

        // Generate markup
        $markup = sprintf($this->getMessageOpenFormat(), ' class="' . implode(' ', $classes) . '"');
        $markup .= implode($this->getMessageSeparatorString(), $messagesToPrint);
        $markup .= $this->getMessageCloseString();

        return $markup;
    }

    /**
     * Set the string used to close message representation
     *
     * @param  string $messageCloseString
     *
     * @return FlashMessenger
     */
    public function setMessageCloseString($messageCloseString)
    {
        $this->messageCloseString = (string)$messageCloseString;

        return $this;
    }

    /**
     * Get the string used to close message representation
     * @return string
     */
    public function getMessageCloseString()
    {
        return $this->messageCloseString;
    }

    /**
     * Set the formatted string used to open message representation
     *
     * @param  string $messageOpenFormat
     *
     * @return FlashMessenger
     */
    public function setMessageOpenFormat($messageOpenFormat)
    {
        $this->messageOpenFormat = (string)$messageOpenFormat;

        return $this;
    }

    /**
     * Get the formatted string used to open message representation
     * @return string
     */
    public function getMessageOpenFormat()
    {
        return $this->messageOpenFormat;
    }

    /**
     * Set the string used to separate messages
     *
     * @param  string $messageSeparatorString
     *
     * @return FlashMessenger
     */
    public function setMessageSeparatorString($messageSeparatorString)
    {
        $this->messageSeparatorString = (string)$messageSeparatorString;

        return $this;
    }

    /**
     * Get the string used to separate messages
     * @return string
     */
    public function getMessageSeparatorString()
    {
        return $this->messageSeparatorString;
    }

    /**
     * Retrieve the escapeHtml helper
     * @return EscapeHtml
     */
    protected function getEscapeHtmlHelper()
    {
        if ($this->escapeHtmlHelper) {
            return $this->escapeHtmlHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->escapeHtmlHelper = $this->view->plugin('escapehtml');
        }

        if (!$this->escapeHtmlHelper instanceof EscapeHtml) {
            $this->escapeHtmlHelper = new EscapeHtml();
        }

        return $this->escapeHtmlHelper;
    }

    /**
     * Get the flash messenger plugin
     * @return PluginFlashMessenger
     */
    public function getPluginFlashMessenger()
    {
        if (null === $this->pluginFlashMessenger) {
            $this->setPluginFlashMessenger(new PluginFlashMessenger());
        }

        return $this->pluginFlashMessenger;
    }

    /**
     * Set the flash messenger plugin
     * @return SuperMessenger
     */
    public function setPluginFlashMessenger(PluginSuperMessenger $pluginFlashMessenger)
    {
        $this->pluginFlashMessenger = $pluginFlashMessenger;

        return $this;
    }
}
