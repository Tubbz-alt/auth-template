<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Factory;

use Meiko\Authentication\Event\DefaultLoginEvent;
use Meiko\Authentication\Event\LoginEventI;
use Meiko\Helper\ConfigReader;
use Meiko\Authentication\Helper\AuthExceptions;

class LoginEventFactory
{

    public static function invoke(): LoginEventI
    {
        $class = ConfigReader::read('eventhandler', 'classname');

        if (! isset($class) || $class == '') {
            return self::getDefaultLoginEvent();
        }

        $event = self::getClassOfString($class);

        if (! $event instanceof LoginEventI) {
            return self::getDefaultLoginEvent();
        }
        return $event;
    }

    private function getClassOfString($class)
    {
        $refclass;
        try {
            $refclass = new \ReflectionClass($class);
        } catch (\ReflectionException $e) {
            throw new \ErrorException(sprintf(' %s: %s. Check your configuration.', AuthExceptions::CLASS_NOT_INSTANTIABLE, $class));
        }

        if (! $refclass->isInstantiable()) {
            throw new \ErrorException(sprintf(' %s: %s. Check your configuration.', AuthExceptions::CLASS_NOT_INSTANTIABLE, $class));
        }
        return $refclass->newInstance();
    }

    private function showConfigError($e)
    {
        echo $e->getMessage();
    }

    private function getDefaultLoginEvent()
    {
        return new DefaultLoginEvent();
    }
}