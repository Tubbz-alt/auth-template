<?php

namespace Install\Helper;

interface CrudInterface
{
    public function getId() : int;
    public function setId($id);
}