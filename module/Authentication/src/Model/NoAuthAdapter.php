<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Model;

use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AdapterInterface;

class NoAuthAdapter implements AdapterInterface
{

    public function authenticate()
    {
        return new Result(Result::SUCCESS, null, [
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
