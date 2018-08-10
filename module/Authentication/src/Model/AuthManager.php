<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Model;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\Ldap as LdapAdapter;
use Meiko\Authentication\Event\LoginEvent;
use Meiko\Authentication\Factory\LoginEventFactory;
use Meiko\Helper\ConfigReader;
use Meiko\Authentication\Helper\LoginEventManager;
use Meiko\Helper\Log;

class AuthManager
{

    private $adapter;

    private $authService;

    private $authMethod;

    private $username;

    private $password;

    private $loginEventManager;

    private $log;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
        $this->authMethod = ConfigReader::read("authentication", "method");

        $this->loginEventManager = new LoginEventManager();
        $this->loginEventManager->attach(LoginEvent::PRELOGIN, [
            LoginEventFactory::invoke(),
            'runPreLogin'
        ]);
        $this->loginEventManager->attach(LoginEvent::POSTLOGIN, [
            LoginEventFactory::invoke(),
            'runPostLogin'
        ]);

        $this->log = Log::getInstance();
    }

    private function initAdapter(string $username = null, string $password = null)
    {
        if (! AuthenticationMethod::isValidName($this->authMethod)) {
            if ($this->authMethod != '') {
                throw new \Exception("Wrong Login configuration. Authentication method is not set correctly.");
            }
        }
        if (AuthenticationMethod::DATABASE == $this->authMethod) {
            $adapter = new DatabaseAuthAdapter(ConfigReader::read('database', 'config'), ConfigReader::read('database', 'username_column'), ConfigReader::read('database', 'password_column'), ConfigReader::read('database', 'usertable'));
        }
        if (AuthenticationMethod::LDAP == $this->authMethod) {
            $adapter = new LdapAdapter(ConfigReader::read('ldap', 'config'));
        }
        if (AuthenticationMethod::NTLM == $this->authMethod) {
            $adapter = new NtlmAuthAdapter(ConfigReader::read('ntlm', 'config'));
        }
        if (AuthenticationMethod::EMPTY == $this->authMethod) {
            $adapter = new NoAuthAdapter();
        }
        $adapter->setPassword($password);
        $adapter->setUsername($username);
        $this->adapter = $adapter;
        return $adapter;
    }

    public function authenticate(string $username = null, string $password = null)
    {
        $this->log->info(AuthManager::class, 'User ' . $username . ' trying to authenticate...');

        $adapter = $this->initAdapter($username, $password);

        $this->triggerLoginEvent(LoginEvent::PRELOGIN, $this);
        $authCode = $this->authService->authenticate($adapter)->getCode();
        $this->triggerLoginEvent(LoginEvent::POSTLOGIN, $this);

        if ($authCode == 1) {
            $this->log->info(AuthManager::class, 'Login for user ' . $username . ' successful');
            return true;
        }
        $this->log->info(AuthManager::class, 'Login for user ' . $username . ' failed');
        return false;
    }

    public function getIdentity()
    {
        return $this->authService->getIdentity();
    }

    public function clearIdentity()
    {
        return $this->authService->clearIdentity();
    }

    public function hasIdentity()
    {
        return $this->authService->hasIdentity();
    }

    private function triggerLoginEvent($name, $target)
    {
        $eventManager = $this->loginEventManager->getEventManager();
        $f = new LoginEventFactory();
        $event = $f::invoke();
        $event->setName($name);
        $event->setTarget($target);
        $eventManager->triggerEvent($event);
        // $this->loginEventManager->attach($name, [get_class($event), $name]);
        // $this->loginEventManager->detach($name, [get_class($event), $name]);
    }
}