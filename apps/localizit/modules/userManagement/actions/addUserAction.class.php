<?php

/**
 * Orange-localizit  System that transalate text into a any language.
 * Copyright (C) 2011 Orange-localizit Inc., http://www.orange-localizit.com
 *
 * Orange-localizit is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * Orange-localizit is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */

/**
 * Description of addUserAction
 *
 * @author waruni
 */
class addUserAction extends sfAction {

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

    public function execute($request) {
        $userManagementService = $this->getUserManagementService();

        $this->addUserForm = new UserForm();

        $this->langList = $this->userManagementService->getLanguageList();
        $userObject = $this->getUser();
        $userObject->setAttribute('user_type_id', 1);

        if ($request->isMethod(sfRequest::POST)) {

            $this->addUserForm->bind($request->getParameter($this->addUserForm->getName()));

            if ($this->addUserForm->isValid()) {
                if ($this->addUserForm->saveUser()) {
                    $this->getUser()->setFlash('successMessage', "Successfully Added User", false);
                    $this->redirect('@userManagement');
                }
            }
            else {
                $globalErrors = $this->addUserForm->getGlobalErrors();
                if (count($globalErrors) > 0) {
                    foreach ($globalErrors as $name => $error) {
                       $this->getUser()->setFlash("errorMessage",$error, false);
                    }
                }
            }
        }
        $this->setTemplate('addUser');
    }

}

