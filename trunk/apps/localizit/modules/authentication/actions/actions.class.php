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
        $this->signInForm = new UserForm($this->authenticationService);
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

    public function executeShow(sfWebRequest $request) {
        $this->user = Doctrine::getTable('User')->find(array($request->getParameter('user_id')));
        $this->forward404Unless($this->user);
    }

    public function executeNew(sfWebRequest $request) {
        $this->form = new UserForm();
    }

    public function executeCreate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST));

        $this->form = new UserForm();

        $this->processForm($request, $this->form);

        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request) {
        $this->forward404Unless($user = Doctrine::getTable('User')->find(array($request->getParameter('user_id'))), sprintf('Object user does not exist (%s).', $request->getParameter('user_id')));
        $this->form = new UserForm($user);
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($user = Doctrine::getTable('User')->find(array($request->getParameter('user_id'))), sprintf('Object user does not exist (%s).', $request->getParameter('user_id')));
        $this->form = new UserForm($user);

        $this->processForm($request, $this->form);

        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();

        $this->forward404Unless($user = Doctrine::getTable('User')->find(array($request->getParameter('user_id'))), sprintf('Object user does not exist (%s).', $request->getParameter('user_id')));
        $user->delete();

        $this->redirect('authentication/index');
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $user = $form->save();

            $this->redirect('authentication/edit?user_id=' . $user->getUserId());
        }
    }

}
