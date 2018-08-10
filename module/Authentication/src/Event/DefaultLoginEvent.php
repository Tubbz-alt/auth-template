<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Event;

use Meiko\Helper\Log;

class DefaultLoginEvent extends LoginEvent implements LoginEventI
{

    public static function runPreLogin()
    {
        $log = Log::getInstance();
        $log->info(DefaultLoginEvent::class, "Pre login Script called");
    }

    public static function runPostLogin()
    {
        $log = Log::getInstance();
        $log->debug(DefaultLoginEvent::class, "Post login Script called");
    }
}