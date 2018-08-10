<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Model;

use Zend\Ldap\Ldap;
use Zend\Ldap\Exception\LdapException as LdapException;
use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AdapterInterface;

class NtlmAuthAdapter implements AdapterInterface
{

    private $ldap;

    public function __construct($config)
    {
        $this->ldap = new Ldap($config);
    }

    public function authenticate()
    {
        $acctname = null;
        try {
            $acctname = $this->ldap->getCanonicalAccountName($_SERVER['AUTH_USER'], Ldap::ACCTNAME_FORM_BACKSLASH);
        } catch (LdapException $ex) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, [
                'Invalid credentials.'
            ]);
        }

        if (is_null($acctname) || $acctname == "") {
            return new Result(Result::FAILURE, null, [
                'no account, probably no NTLM auth defined.'
            ]);
        }
        return new Result(Result::SUCCESS, $acctname, [
            'Authenticated successfully.'
        ]);
    }

    public function getAdapter()
    {
        return $this;
    }

    /*
     * does nothing, needs to be implemented because other Classes which implement AdapterInterface call this
     */
    public function setPassword($password)
    {}

    /*
     * does nothing, needs to be implemented because other Classes which implement AdapterInterface call this
     */
    public function setUsername($username)
    {}
}
