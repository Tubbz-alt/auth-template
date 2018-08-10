<?php

namespace Install\Helper;

class TaskModel implements CrudInterface
{
    public $taskname;
    public $description;
    public $assigned_to;
    private $id;
    
    public function __construct($taskname = '', $description = '', $assigend_to = null)
    {
        $this->taskname = $taskname;
        $this->description = $description;
        $this->assigned_to = 2;
    }
    public function setId($id)
    {        
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

}