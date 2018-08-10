<?php
/**
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 */

namespace Install\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Install\Helper\CrudRepository;
use Zend\Db\Adapter\Adapter as DatabaseAdapter;
use Authentication\Helper\ConfigReader;
use Zend\View\Model\ViewModel;
use Install\Helper\TaskModel;
use function False\true;

class CrudController extends AbstractActionController
{
    private $rep;
    
    public function __construct()
    {        
        $dbConfig = ConfigReader::read('database', 'config');
        $adapter = new DatabaseAdapter($dbConfig);
        $table = 'task';
        $id_column = 'id';
        $object_name = 'Install\Helper\TaskModel';
        $mapResultsToObject = true;
        $this->rep = new CrudRepository($adapter, $table, $id_column);
        $this->rep->returnValuesAsObject($object_name);
        //$this->rep->returnValuesAsArray();
    }
    
    public function readAction()
    {        
        
        //get
        //\Zend\Debug\Debug::dump($this->rep->getAll());
        //\Zend\Debug\Debug::dump($this->rep->get(1));
        //\Zend\Debug\Debug::dump($this->rep->getByColumnValue('testing update function from repository', 'description'));
        
        //insert
        /*
         *         $values =
        [
            //'id' => '45',
            'taskname' => 'insert',
            'description' => 'testing insert with values only',
        ];
        
        $this->rep->insert($values);
        
        //insertItem
        $mockTask = new TaskModel('insert_test', 'testing inserts', 2);
        \Zend\Debug\Debug::dump($this->rep->insert($mockTask));
        

        
        //delete - returns true if id does not exist
        \Zend\Debug\Debug::dump($this->rep->delete(4));
        */
        //update
        $values = [
            'taskname' => 'update',
            'description' => 'testing update function from repository',
        ];
        \Zend\Debug\Debug::dump($this->rep->update(2, $values));
        //updateItem
        /*
        $mockTask = new TaskModel('insert_test', 'testing inserts', 2);
        $mockTask->setId(8);
        $mockTask->taskname = 'updateItem';
        $mockTask->description = 'updateItem function did this';
        \Zend\Debug\Debug::dump($this->rep->updateItem($mockTask));
        */
        
        
        return new ViewModel();
    }
}