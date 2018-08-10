<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Meiko\Authentication\Helper\UserRepository;

class RegistrationController extends AbstractActionController
{

    public function registerAction()
    {
        $success = true;
        if ($this->request->isPost()) {
            $data = $this->params()->fromPost();
            $username = $data['username'];
            $password = $data['password'];
            $success = $this->registerUser($username, $password);
        }
        return new ViewModel([
            'success' => $success
        ]);
    }

    private function registerUser(string $username, string $password)
    {
        $repo = new UserRepository();
        $success = $repo->registerUser($username, $password);
        return $success;
    }
}
