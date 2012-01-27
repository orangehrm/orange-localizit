<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of deleteAction
 *
 * @author waruni
 */
class deleteAction extends sfAction {

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
     * Delete User .
     * @param <type> $request
     */

    public function execute($request) {
        $result = $this->userManagementService->deleteUser($request['user_id']);
        $this->redirect('@userManagement');
    }

}

