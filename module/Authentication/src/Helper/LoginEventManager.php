<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Helper;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

class LoginEventManager implements EventManagerAwareInterface
{

    private $events;

    public function __construct()
    {
        $this->events = $this->getEventManager();
    }

    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers([
            __CLASS__,
            get_class($this)
        ]);

        $this->events = $events;
    }

    public function getEventManager()
    {
        if (! $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

    public function attach($eventName, callable $listener)
    {
        $this->events->attach($eventName, $listener);
    }

    public function detach($eventName, callable $listener)
    {
        $this->events->detach($listener, $eventName);
    }
}