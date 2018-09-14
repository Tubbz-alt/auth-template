<?php

/**
 *
 * @link https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author Daniel Kopf
 */
namespace Meiko\Authentication;

use Meiko\Helper\ConfigReader as Reader;
use Meiko\Authentication\Controller\LoginController;
use Meiko\Authentication\Model\AuthManager;
use Meiko\Authentication\Controller\RegistrationController;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;

class Module
{
   const VERSION='3.0.3-dev';

   public function getConfig()
   {
      return include __DIR__ . '/../config/module.config.php';
   }

   public function onBootstrap(MvcEvent $e)
   {
      $eventManager=$e->getApplication()->getEventManager();
      $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
            $this,
            'protectPage'
      ), 99);
      
      if(! Reader::read('authentication', 'registration'))
      {
         $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
               $this,
               'redirectRegistration'
         ), 100);
      }
   }

   public function protectPage(MvcEvent $event)
   {
      $controllerName=$event->getRouteMatch()->getParam('controller', null);
      $actionName=$event->getRouteMatch()->getParam('action', null);
      
      if($controllerName == LoginController::class || $controllerName == RegistrationController::class)
      {
         return;
      }
      
      $match=$event->getRouteMatch();
      if(! $match)
      {
         return;
      }
      $authService=$event->getApplication()->getServiceManager()->get(AuthenticationService::class);
      $authManager=new AuthManager($authService);
      
      if($authManager->getIdentity() != null)
      {
         return;
      }
      
      if($authManager->authenticate())
      {
         return;
      }
      else
      {
         $event->stopPropagation(true);
         $uri=$event->getApplication()->getRequest()->getUri();
         $uri->setScheme(null)->setHost(null)->setPort(null)->setUserInfo(null);
         $redirectUrl=$uri->toString();
         
         $event->setControllerClass(LoginController::class);
         $controller=new Controller\LoginController($authManager);
         $controller->setEvent($event);
         $controller->redirect()->toRoute('auth', [
               'action' => 'login'
         ], [
               'query' => [
                     'redirectUrl' => $redirectUrl
               ]
         ]);
      }
   }

   public function redirectRegistration(MvcEvent $event)
   {
      $controllerName=$event->getRouteMatch()->getParam('controller', null);
      
      if($controllerName == RegistrationController::class)
      {
         $authService=$event->getApplication()->getServiceManager()->get(AuthenticationService::class);
         $authManager=new AuthManager($authService);
         $event->setControllerClass(LoginController::class);
         $controller=new Controller\LoginController($authManager);
         $controller->setEvent($event);
         $controller->redirect()->toRoute('auth', [
               'action' => 'login'
         ]);
      }
   }
}
