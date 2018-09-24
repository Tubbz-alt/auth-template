<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Model;

use Meiko\Helper\BasicEnum;

/*
 * Abstract class with contains all valid authentication methods as constants.
 */
abstract class AuthenticationMethod extends BasicEnum
{

    const DATABASE = 'DATABASE';

    const LDAP = 'LDAP';

    const NTLM = 'NTLM';

    const EMPTY = '';
}