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

    /**
     * Page Index
     * @param sfWebRequest $request
     */
    public function executeIndex(sfWebRequest $request) {
        if ($this->getUser()->isAuthenticated()) {
            $this->redirect('@homepage');
        }
    }
}
