<?php

class myUser extends sfBasicSecurityUser
{
    public $userRole;

    public function getUserRole(){
        $this->userRole = new UserRole();
        $this->userRole->setSfUser($this);
        $this->userRole->setUser($this->getAttribute('loginUser'));
        
        return $this->userRole;
    }
}
