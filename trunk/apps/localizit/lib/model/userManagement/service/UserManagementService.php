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
 * Description of UserManagementService
 *
 * @author waruni
 */
class UserManagementService extends BaseService {

// Define variables

    private $userManagementDao;

    /**
     * UserManagementDao get Method.
     * @return <type>
     */
    public function getUserManagementDao() {
        return $this->userManagementDao;
    }

    /**
     * setUserManagement Method.
     * @param UserManagementDao $userManagementDao
     */
    public function setUserManagementDao(UserManagementDao $userManagementDao) {
        $this->userManagementDao = $userManagementDao;
    }

    /**
     *  Add User Method.
     * @param <type> $userName
     * @param <type> $password
     * @param <type> $userTypeId
     * @return <type> 
     */
    public function addUser($userName, $password, $userTypeId) {

        $userManagementDao = $this->getUserManagementDao();

        try {
            $user = new User();
            $user->setUsername($userName);
            $user->setPassword($this->hashPassword($password));
            $user->setUserTypeId($userTypeId);

            $response = $userManagementDao->addUser($user);
            return $response;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Update User
     */
    public function updateUser(User $user) {
        $userManagementDao = $this->getUserManagementDao();
        try {
            $response = $userManagementDao->updateUser($user);
            
            return $response;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Add User Language Method.
     * @param UserLanguage $userLang
     * @return <type> 
     */
    public function addUserLang(UserLanguage $userLang) {
        $userManagementDao = $this->getUserManagementDao();
        try {
            $response = $userManagementDao->addUserLang($userLang);
            return $response;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Update User Language
     */
    public function updateUserLang(UserLanguage $userLang) {
        $userManagementDao = $this->getUserManagementDao();
        try {
            $response = $userManagementDao->addUserLang($userLang);
            return $response;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Delete User Languages.
     */
    public function deleteUserLanguages($userId) {
        $userManagementDao = $this->getUserManagementDao();
        try {
            $result = $userManagementDao->deleteUserLanguages($userId);
            return $result;
        } catch (Exception $exception) {
            throw new ServiceException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Hash Password using md5.
     */
    public function hashPassword($password) {
        return md5($password);
    }

    /**
     * Get user type list
     */
    public function getUserTypeList() {
        $userManagementDao = $this->getUserManagementDao();
        try {
            $res = $userManagementDao->getDataList('UserType');
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Get Language List
     */
    public function getLanguageList() {
        $userManagementDao = $this->getUserManagementDao();
        try {
            $res = $userManagementDao->getDataList('Language');
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Get Language List for User
     */
    public function getUserLanguageList($userId) {
        $userManagementDao = $this->getUserManagementDao();
        try {
            $res = $userManagementDao->getUserLanguageList($userId);
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Get User By Id .
     */
    public function getUserById($userId) {
        $userManagementDao = $this->getUserManagementDao();
        try {
            $res = $userManagementDao->getUserById($userId);
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Delete User
     */
    public function deleteUser($userId) {
        $userManagementDao = $this->getUserManagementDao();
        try {
            $res = $userManagementDao->deleteUser($userId);
            return $res;
        } catch (Exception $exception) {
            throw new ServiceException($exception->getMessage(), $exception->getCode());
        }
    }

}