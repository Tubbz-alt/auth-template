<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Helper;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Meiko\Helper\ConfigReader;
use Meiko\Helper\CryptoHelper;

class UserRepository
{

    private $adapter;

    private $table;

    private $username_column;

    private $password_column;

    public function __construct()
    {
        $this->adapter = new Adapter(ConfigReader::read('database', 'config'));
        $this->table = ConfigReader::read('database', 'usertable');
        $this->username_column = ConfigReader::read('database', 'username_column');
        $this->password_column = ConfigReader::read('database', 'password_column');
    }

    public function getUser(int $id)
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table);
        $select->where([
            'id' => $id
        ]);

        $statement = $sql->prepareStatementForSqlObject($select);
        return $statement->execute();
    }

    public function getUserByName(string $name)
    {
        $column = $this->username_column;
        ;

        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table);
        $select->where([
            $column => $name
        ]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $this->mapResultToUser($result);
    }

    public function getUsers()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from($this->table);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $this->mapResultToUser($result);
    }

    public function registerUser($name, $password)
    {
        if ($this->hasAccount($name)) {
            return false;
        }

        $this->createUser($name, $password);

        $statement = $this->adapter->createStatement('INSERT INTO user (username, password)
            VALUES(?, ?)', $params);
        $result = $statement->execute();

        return true;
    }

    private function createUser($name, $password)
    {
        $columns = [
            $this->username_column,
            $this->password_column
        ];

        $params = [
            $name,
            CryptoHelper::encrpyt($password)
        ];
        $password = null;

        $sql = new Sql($this->adapter);
        $insert = $sql->insert();
        $insert->columns([
            $columns
        ]);
        $insert->into($this->table);
        $insert->values($params);

        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute($params);
    }

    private function mapResultToUser($result)
    {
        $users = null;
        foreach ($result as $row) {
            $users[] = $row;
        }
        return $users;
    }

    public function hasAccount($name)
    {
        $user = $this->getUserByName($name);
        if (! is_null($user)) {
            return true;
        } else
            return false;
    }
}