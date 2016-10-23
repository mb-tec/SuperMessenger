<?php

/*
 * This file is part of the SuperMessenger package.
 * @copyright Copyright (c) 2012 Blanchon Vincent - France (http://developpeur-zend-framework.fr - blanchon.vincent@gmail.com)
 */

namespace SuperMessenger\Controller\Plugin;

use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Session\Container;

class SuperMessenger extends FlashMessenger
{
    /**
     * Default messages namespace
     */
    const DEFAULT_MESSAGE = 'default';

    /**
     * Success messages namespace
     */
    const SUCCESS_MESSAGE = 'success';

    /**
     * Error messages namespace
     */
    const ERROR_MESSAGE = 'error';

    /**
     * Info messages namespace
     */
    const INFO_MESSAGE = 'info';

    /**
     * Get session container for flash messages
     *
     * @return Container
     */
    public function getContainer()
    {
        if ($this->container instanceof Container) {
            return $this->container;
        }

        $manager = $this->getSessionManager();
        $this->container = new Container('SuperMessenger', $manager);

        return $this->container;
    }

    /**
     * Add a message with "info" type
     *
     * @param  string         $message
     * @return FlashMessenger
     */
    public function addInfoMessage($message)
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::INFO_MESSAGE);
        $this->addMessage($message);
        $this->setNamespace($namespace);
        return $this;

    }

    /**
     * Add a message with "success" type
     *
     * @param  string         $message
     * @return FlashMessenger
     */
    public function addSuccessMessage($message)
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::SUCCESS_MESSAGE);
        $this->addMessage($message);
        $this->setNamespace($namespace);
        return $this;
    }

    /**
     * Add a message with "error" type
     *
     * @param  string         $message
     * @return FlashMessenger
     */
    public function addErrorMessage($message)
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::ERROR_MESSAGE);
        $this->addMessage($message);
        $this->setNamespace($namespace);
        return $this;
    }

    /**
     * Whether "info" namespace has messages
     *
     * @return boolean
     */
    public function hasInfoMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::INFO_MESSAGE);
        $hasMessages = $this->hasMessages();
        $this->setNamespace($namespace);
        return $hasMessages;
    }

    /**
     * Whether "success" namespace has messages
     *
     * @return boolean
     */
    public function hasSuccessMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::SUCCESS_MESSAGE);
        $hasMessages = $this->hasMessages();
        $this->setNamespace($namespace);
        return $hasMessages;
    }

    /**
     * Whether "error" namespace has messages
     *
     * @return boolean
     */
    public function hasErrorMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::ERROR_MESSAGE);
        $hasMessages = $this->hasMessages();
        $this->setNamespace($namespace);
        return $hasMessages;
    }

    /**
     * Get messages from a specific namespace
     *
     * @return array
     */
    public function getMessagesFromNamespace($namespaceToGet)
    {
        $namespace = $this->getNamespace();
        $this->setNamespace($namespaceToGet);
        $messages = $this->getMessages();
        $this->setNamespace($namespace);
        return $messages;
    }

    /**
     * Get messages from "info" namespace
     *
     * @return array
     */
    public function getInfoMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::INFO_MESSAGE);
        $messages = $this->getMessages();
        $this->setNamespace($namespace);
        return $messages;
    }

    /**
     * Get messages from "success" namespace
     *
     * @return array
     */
    public function getSuccessMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::SUCCESS_MESSAGE);
        $messages = $this->getMessages();
        $this->setNamespace($namespace);
        return $messages;
    }

    /**
     * Get messages from "error" namespace
     *
     * @return array
     */
    public function getErrorMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::ERROR_MESSAGE);
        $messages = $this->getMessages();
        $this->setNamespace($namespace);
        return $messages;
    }

    /**
     * Clear all messages from specific namespace
     *
     * @return boolean True if messages were cleared, false if none existed
     */
    public function clearMessagesFromNamespace($namespaceToClear)
    {
        $namespace = $this->getNamespace();
        $this->setNamespace($namespaceToClear);
        $cleared = $this->clearMessages();
        $this->setNamespace($namespace);
        return $cleared;
    }

    /**
     * Clear all messages from the container
     *
     * @return boolean True if messages were cleared, false if none existed
     */
    public function clearMessagesFromContainer()
    {
        $this->getMessagesFromContainer();
        if (empty($this->messages)) {
            return false;
        }
        unset($this->messages);
        $this->messages = array();

        return true;
    }

    /**
     * Check to see if messages have been added to "info"
     * namespace within this request
     *
     * @return boolean
     */
    public function hasCurrentInfoMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::INFO_MESSAGE);
        $hasMessages = $this->hasCurrentMessages();
        $this->setNamespace($namespace);
        return $hasMessages;
    }

    /**
     * Check to see if messages have been added to "success"
     * namespace within this request
     *
     * @return boolean
     */
    public function hasCurrentSuccessMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::SUCCESS_MESSAGE);
        $hasMessages = $this->hasCurrentMessages();
        $this->setNamespace($namespace);
        return $hasMessages;
    }

    /**
     * Check to see if messages have been added to "error"
     * namespace within this request
     *
     * @return boolean
     */
    public function hasCurrentErrorMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::ERROR_MESSAGE);
        $hasMessages = $this->hasCurrentMessages();
        $this->setNamespace($namespace);
        return $hasMessages;
    }

    /**
     * Get messages that have been added to the current
     * namespace in specific namespace
     *
     * @return array
     */
    public function getCurrentMessagesFromNamespace($namespaceToGet)
    {
        $namespace = $this->getNamespace();
        $this->setNamespace($namespaceToGet);
        $messages = $this->getCurrentMessages();
        $this->setNamespace($namespace);
        return $messages;
    }

    /**
     * Get messages that have been added to the "info"
     * namespace within this request
     *
     * @return array
     */
    public function getCurrentInfoMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::INFO_MESSAGE);
        $messages = $this->getCurrentMessages();
        $this->setNamespace($namespace);
        return $messages;
    }

    /**
     * Get messages that have been added to the "success"
     * namespace within this request
     *
     * @return array
     */
    public function getCurrentSuccessMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::SUCCESS_MESSAGE);
        $messages = $this->getCurrentMessages();
        $this->setNamespace($namespace);
        return $messages;
    }

    /**
     * Get messages that have been added to the "error"
     * namespace within this request
     *
     * @return array
     */
    public function getCurrentErrorMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::ERROR_MESSAGE);
        $messages = $this->getCurrentMessages();
        $this->setNamespace($namespace);
        return $messages;
    }

    /**
     * Clear messages from the current namespace
     *
     * @return boolean
     */
    public function clearCurrentMessagesFromNamespace($namespaceToClear)
    {
        $namespace = $this->getNamespace();
        $this->setNamespace($namespaceToClear);
        $cleared = $this->clearCurrentMessages();
        $this->setNamespace($namespace);
        return $cleared;
    }

    /**
     * Clear messages from the container
     *
     * @return boolean
     */
    public function clearCurrentMessagesFromContainer()
    {
        $container = $this->getContainer();

        $namespaces = array();
        foreach ($container as $namespace => $messages) {
            $namespaces[] = $namespace;
        }

        if (empty($namespaces)) {
            return false;
        }

        foreach ($namespaces as $namespace) {
            unset($container->{$namespace});
        }

        return true;
    }
}
