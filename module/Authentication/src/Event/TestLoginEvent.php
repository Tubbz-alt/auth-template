<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Event;

class TestLoginEvent extends LoginEvent implements LoginEventI
{

    public static function runPreLogin()
    {
        echo "pre login event handeled in TestLoginEvent <br>";
    }

    public static function runPostLogin()
    {
        echo "post login event handeled in TestLoginEvent <br>";
    }
}