<?php

namespace Install\Helper;

class FileWriter
{
    private $file;
    
    function __construct($file)
    {
        $this->file = $file;
    }
    
    private function writeRow($file, $key, $value)
    {
        $row = $this->formatKeyValueToRow($key, $value);
        fwrite($file, $row);
    }
    
    function writeFile($params)
    {
        $keys = array_keys($params);
        $file = fopen($this->file, "w");
        
        foreach($keys as $key)
        {
            $normalizedKey = self::normalizeKey($key);
            $param = self::addQuotesToString($params[$key]);
            self::writeRow($file, $normalizedKey, $param);
        } 
        fclose($file);
    }
    
    private function normalizeKey($key)
    {
        return str_replace('-', '.', $key);
    }
    
    private function formatKeyValueToRow($key, $value)
    {
        return sprintf("%s = %s\n", $key, $value);
    }
    
    private function addQuotesToString($string)
    {
        if(is_string($string))
           return sprintf('\'%s\'', $string);
        return $string;
    }
}