<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Factory;

use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Session\SessionManager;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Config\StandardConfig;
use Meiko\Helper\ConfigReader;

class AuthenticationServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = new StandardConfig();
        $authMethod = ConfigReader::read('authentication', 'method');
        if (! $authMethod == '' || ! is_null($authMethod))
            $config->setOptions(ConfigReader::read('session', 'config'));
        $session = new SessionManager($config);
        $session->start();
        $authStorage = new SessionStorage('Zend_Auth', 'session', $session);
        return new AuthenticationService($authStorage);
    }
}