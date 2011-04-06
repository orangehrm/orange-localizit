<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of editUserAction
 *
 * @author waruni
 */
class editUserAction extends sfAction {

    private $userManagementService;

    /**
     * This method is executed before each action
     */
    public function preExecute() {

        $this->userManagementService = $this->getUserManagementService();
    }

    /**
     * Get Localization Service
     */
    public function getUserManagementService() {
        $this->userManagementService = new UserManagementService();
        $this->userManagementService->setUserManagementDao(new UserManagementDao());
        return $this->userManagementService;
    }

    /**
     * Edit User.
     * @param <type> $request 
     */
    public function execute($request) {
        $userObject = $this->getUser();
        $this->langList = $this->userManagementService->getLanguageList();
        $this->user = $this->userManagementService->getUserById($request['id']);
        $this->userLang = $this->userManagementService->getUserLanguageList($request['id']);
        $this->id = $request['id'];
        $this->editUserForm = new UserForm($this->user);
        $userObject->setAttribute('user_type_id', $this->user['user_type_id']);

        if ($request->isMethod(sfRequest::POST)) {
            $this->editUserForm->bind($request->getParameter($this->editUserForm->getName()));

            if ($this->editUserForm->isValid()) {
                if ($this->editUserForm->updateUser()) {
                    $this->redirect('@userManagement');
               }
            } 
        }
    }
}
