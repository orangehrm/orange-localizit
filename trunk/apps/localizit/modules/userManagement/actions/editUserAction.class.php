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
        $user = $this->userManagementService->getUserById($request['id']);
        $this->editUserForm = new UserForm($user);
    }

}
