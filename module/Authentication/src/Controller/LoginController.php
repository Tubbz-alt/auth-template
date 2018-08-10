<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication\Controller;

use Meiko\Authentication\Model\AuthManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Uri\Uri;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{

    private $authManager;

    private $pre;

    private $post;

    public function __construct(AuthManager $authService)
    {
        $this->authManager = $authService;
    }

    public function loginAction()
    {
        if ($this->getRequest()->isGet()) {
            return new ViewModel([
                'redirectUrl' => '',
                'isLoginError' => false,
                'isAuth' => $this->authManager->hasIdentity(),
                'userName' => $this->authManager->getIdentity()
            ]);
        }

        $isLoginError = false;
        $redirectUrl = (string) $this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl) > 2048) {
            throw new \Exception("Too long redirectUrl argument passed");
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $username = $data['username'];
            $password = $data['password'];

            $isLogin = $this->authManager->authenticate($username, $password);

            if ($isLogin) {
                $isLoginError = false;
                $redirectUrl = $this->params()->fromPost('redirectUrl', '');

                if (! empty($redirectUrl)) {
                    $uri = new Uri($redirectUrl);
                    if (! $uri->isValid() || $uri->getHost() != null)
                        throw new \Exception('Incorrect redirect URL: ' . $redirectUrl);
                }
                if (empty($redirectUrl)) {
                    return $this->redirect()->toRoute('home');
                } else {
                    return $this->redirect()->toUrl($redirectUrl);
                }
            } else {
                $isLoginError = true;
            }
        }

        $viewModel = new ViewModel([
            'redirectUrl' => $redirectUrl,
            'isLoginError' => $isLoginError,
            'isAuth' => $isLogin,
            'userName' => null
        ]);
        return $viewModel;
    }

    public function logoutAction()
    {
        $isLogin = $this->authManager->hasIdentity();
        if ($isLogin)
            $this->authManager->clearIdentity();
        return new ViewModel();
    }
}
