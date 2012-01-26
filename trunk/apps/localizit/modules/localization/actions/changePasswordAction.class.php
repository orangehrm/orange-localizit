<?php

class changePasswordAction extends sfAction {
    private $userManagementService;
    
    public function preExecute() {
        if(!$this->getUser()->isAuthenticated()) {
            $this->redirect('@loginpage');
        }
        $this->userManagementService = new UserManagementService();
        $this->userManagementService->setUserManagementDao(new UserManagementDao());
        $this->user = $this->getUser()->getAttribute('loginUser');
    }
    public function execute($request) {
        $this->changePasswordForm = new ChangePasswordForm();
        $this->user = $this->userManagementService->getUserById($this->user->getId());
        if ($request->isMethod('post')){
            $this->changePasswordForm->bind($request->getParameter('changePassword'));
            if ($this->changePasswordForm->isValid()) {
               $user = new User();
               $user->setId($this->user->getId());
               $user->setUsername($this->user->getUsername());
               $user->setUserTypeId($this->user->getUserTypeId());
               $user->setPassword($this->userManagementService->hashPassword($this->changePasswordForm['new_password']->getValue()));
               $this->userManagementService->updateUser($user);
               $newUser = $this->userManagementService->getUserById($user->getId());
               $this->getUser()->setAttribute('loginUser', $newUser);
               $this->getUser()->setFlash('successMessage', "Successfully Reset the Password", false);
            } else {
                $globalErrors=$this->changePasswordForm->getGlobalErrors();
                if(count($globalErrors)>0) {
                    foreach ($globalErrors as $name => $error) {
                        $this->getUser()->setFlash("errorMessage",$error, false); 
                    }
                }
            }
        }
    }
}