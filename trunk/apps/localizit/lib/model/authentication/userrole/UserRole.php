<?php

/*
 *
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2011 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
 */

class UserRole implements RoleDecorator {

    public $user;
    public $sfUser;
    public $userRoleDecoratorFactory;

    public function setUserRoleDecoratorFactory($userRoleDecoratorFactory) {
        $this->userRoleDecoratorFactory = $userRoleDecoratorFactory;
    }

    public function getUserRoleDecoratorFactory() {
        if ($this->userRoleDecoratorFactory == null) {
            return new UserRoleDecoratorFactory();
        } else {
            return $this->userRoleDecoratorFactory;
        }
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getUser() {
        return $this->user;
    }

    public function setSfUser($sfUser) {
        $this->sfUser = $sfUser;
    }

    public function getSfUser() {
        return $this->sfUser;
    }

    public function isAllowedToManageUser() {

        foreach ($this->getUserRoleDecorator() as $roleDecorator) {
            if ($roleDecorator->isAllowedToManageUser()) {
                return true;
            }
        }
        return false;
    }

    public function isAllowedToAddLabel() {

        foreach ($this->getUserRoleDecorator() as $roleDecorator) {
            if ($roleDecorator->isAllowedToAddLabel()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @author Chameera Senarathna
     * @return Allowed Language list
     */
    public function getAllowedLanguageList() {

        $allowedLanguageList = array();

        foreach ($this->getUserRoleDecorator() as $roleDecorator) {
            $allowedLanguageList = array_merge($allowedLanguageList, $roleDecorator->getAllowedLanguageList());
        }

        return $allowedLanguageList;
    }

    public function isAllowedToDownloadDirectory() {

        foreach ($this->getUserRoleDecorator() as $roleDecorator) {
            if ($roleDecorator->isAllowedToDownloadDirectory()) {
                return true;
            }
        }
        return false;
    }

    public function isAllowedToTranslateText() {

        foreach ($this->getUserRoleDecorator() as $roleDecorator) {
            if ($roleDecorator->isAllowedToTranslateText()) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Allow user to add Language Group
     */
    public function isAllowedToAddLanguageGroup() {

        foreach ($this->getUserRoleDecorator() as $roleDecorator) {
            if ($roleDecorator->isAllowedToAddLanguageGroup()) {
                return true;
            }
        }
        return false;
    }

    /**
     * get user role Decorator
     * @return unknown_type
     */
    public function getUserRoleDecorator() {
        $user = $this->getUser();
        $SfUser = $this->getSfUser();
        $decoratorFactory = $this->getUserRoleDecoratorFactory();
        $roleDecoratorChain = array();

        if ($SfUser->isAuthenticated()) {
            if ($SfUser->hasCredential('Admin')) {
                $roleDecorator = $decoratorFactory->getRoleDecorator('Admin');
                $roleDecorator->setUser($user);
                array_push($roleDecoratorChain, $roleDecorator);
            }

            if ($SfUser->hasCredential('Moderator')) {
                $roleDecorator = $decoratorFactory->getRoleDecorator('Moderator');
                $roleDecorator->setUser($user);
                array_push($roleDecoratorChain, $roleDecorator);
            }
        } else {
            $roleDecorator = $decoratorFactory->getRoleDecorator('NormalUser');
            $roleDecorator->setUser($user);
            array_push($roleDecoratorChain, $roleDecorator);
        }

        return $roleDecoratorChain;
    }

}