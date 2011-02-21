<?php

/**
 * authentication actions.
 *
 * @package    localizit
 * @subpackage authentication
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authenticationActions extends sfActions {

    private $authenticationService;

    /**
     * This method is executed before each action
     */
    public function preExecute() {
        $this->authenticationService = $this->getAuthenticationService();
    }

    public function executeIndex(sfWebRequest $request) {
        if ($this->getUser()->isAuthenticated()) {
            $this->redirect('@homepage');
        }
    }

    /**
     *  Get Authentication Service
     */
    public function getAuthenticationService() {
        $this->authenticationService = new AuthenticationService();
        $this->authenticationService->setAuthenticationDao(new AuthenticationDao());
        return $this->authenticationService;
    }

    /**
     * Login Method
     * @param sfWebRequest $request
     */
    public function executeLogin(sfWebRequest $request) {

        $this->signInForm = new UserForm($this->authenticationService);

        if ($request->isMethod(sfRequest::POST)) {
            $this->signInForm->bind($request->getParameter('sign_in'));
            if ($this->signInForm->isValid()) {
                $this->getUser()->setAuthenticated(true);
                $this->getUser()->addCredential('user');

                $sign_in = $request->getParameter('sign_in');
                $this->getUser()->setAttribute('username', $sign_in['login_name']);

                $this->redirect('@homepage');
            }
        }
        $this->setTemplate('index');
    }

    /**
     *  Log out Method
     * @param sfWebRequest $request
     */
    public function executeLogout() {
        $this->getUser()->clearCredentials();
        $this->getUser()->setAuthenticated(false);
        $this->redirect('@loginpage');
    }

}
