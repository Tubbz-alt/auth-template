<?php
/**
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 */

namespace Install\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Authentication\Helper\ConfigReader;
use Install\Helper\FileWriter;
use Install\Helper\ConfigValues;

class InstallController extends AbstractActionController
{
    
    private $globalConfigPath;
    private $templateConfigFile;
    private $configFile;
    
    public function __construct()
    {
        $this->globalConfigPath = dirname(__FILE__) . "/../../../../config/";
        $this->templateConfigFile = $this->globalConfigPath . "meiko.config.ini.dist";
        $this->configFile = $this->globalConfigPath . "loginconfig.ini";
    }
    
    public function installAction()
    {
        if($this->fileExists($this->configFile))
        {
            return $this->getConfigExistsViewModel();
        }
        return new ViewModel([
            'configExists' => false,
        ]); 
    }
    
    public function defaultConfigAction()
    {
        if($this->fileExists($this->configFile))
        {
            return $this->getConfigExistsViewModel();
        }
        
        if(file_exists($this->templateConfigFile))
        {
            $success = $this->tryCopy($this->templateConfigFile, $this->configFile);
            
            return new ViewModel([
                'fileExists' => true,
                'success' => $success,
            ]);
        }
        return new ViewModel([
            'fileExists' => false,
            'success' => false,
        ]);
    }
    
    public function customizeAction()
    {
        if($this->getRequest()->isPost())
        {
            $params = $this->params()->fromPost();
            $writer = new FileWriter($this->configFile);
            $writer->writeFile($params);
        }
        
        $configParams = ConfigValues::getAll();
        $config = ConfigReader::read();
        $newConfig = array_merge($configParams, $config);
        
        $viewModel = new ViewModel([
             'config' => $newConfig,
        ]);
         $viewModel->setTemplate('install/install/configure');
         return $viewModel;
    }
    
    private function getConfigExistsViewModel()
    {
        $viewModel = new ViewModel([
            'configExists' => true,
        ]);
        $viewModel->setTemplate("install/install/config_exists");
        return $viewModel;
    }
    
    private function tryCopy(string $source, string $destination) : bool
    {
        try
        {
            copy($source, $destination);
        }
        catch(\ErrorException $e)
        {
            return false;
        }
        return true;
    }
    
    private function fileExists(string $file)
    {
        //TODO: error handling
        return file_exists($file);
    }    
}