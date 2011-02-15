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

    public function executeIndex(sfWebRequest $request) {
        $authenticationService = $this->getAuthenticationService();
        $this->addSignInForm = new UserForm($authenticationService);
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
        $authenticationService = $this->getAuthenticationService();
        $this->addSignInForm = new UserForm($authenticationService);

        if ($request->isMethod(sfRequest::POST)) {
            $this->addSignInForm->bind($request->getParameter('sign_in'));
            if ($this->addSignInForm->isValid()) {
                $this->redirect('@homepage');
            }
        }
        $this->setTemplate('index');
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
