<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logoutAction
 *
 * @author waruni
 */
class logoutAction extends sfAction {
  

    /**
     *  Log out Method. Clear session after logout.
     * @param sfWebRequest $request
     */
    public function execute($request) {
        $this->getUser()->clearCredentials();
        $this->getUser()->setAuthenticated(false);
        $this->redirect('@loginpage');
    }

}
