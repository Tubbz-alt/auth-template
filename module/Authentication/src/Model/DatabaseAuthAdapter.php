<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Model;

use Meiko\Helper\CryptoHelper;
use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class DatabaseAuthAdapter implements AdapterInterface
{

    private $sqlAdapter;

    private $sql;

    private $password;

    private $username;

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function __construct($config, $username_colum, $password_colum, $usertable)
    {
        $this->sqlAdapter = new Adapter($config);

        $this->sql = $sql = sprintf('SELECT %s, %s FROM %s WHERE username = %s;', $username_colum, $password_colum, $usertable, "?");
    }

    public function authenticate()
    {
        $parameters = [
            $this->username
        ];

        $statement = $this->sqlAdapter->createStatement($this->sql, $parameters);
        $result = $statement->execute();

        foreach ($result as $row) {
            if ($this->verify($this->password, $row['password'])) {
                return new Result(Result::SUCCESS, $row["username"], [
                    'Authenticated successfully.'
                ]);
            }
        }
        return new Result(Result::FAILURE, null, [
            'not authenticated'
        ]);
    }

    public function getAdapter()
    {
        return $this;
    }

    private function encrpyt($password)
    {
        return CryptoHelper::encrpyt($password);
    }

    private function verify($password, $hash)
    {
        return CryptoHelper::verify($password, $hash);
    }
}
