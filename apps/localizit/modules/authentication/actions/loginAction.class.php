<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loginAction
 *
 * @author waruni
 */
class loginAction extends sfAction {

    private $authenticationService;

    /**
     * This method is executed before each action
     */
    public function preExecute() {
        $this->authenticationService = $this->getAuthenticationService();
    }

    /**
     *  Get Authentication Service
     */
    private function getAuthenticationService() {
        $this->authenticationService = new AuthenticationService();
        $this->authenticationService->setAuthenticationDao(new AuthenticationDao());
        return $this->authenticationService;
    }

    /**
     * Login Method. If user provides valid username and password , create a session.
     * @param <type> $request 
     */

    public function execute($request) {

        $this->authenticationService = $this->getAuthenticationService();
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

}

