<?php

/**
 * Orange-localizit  is a System that transalate text into a any language.
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
 * AuthenticationService for User operation
 *
 * @author Chameera S
 */
class AuthenticationService extends BaseService {

    private $authenticationDao;

    public function getAuthenticationDao() {
        return $this->authenticationDao;
    }

    public function setAuthenticationDao(AuthenticationDao $authenticationDao) {
        $this->authenticationDao = $authenticationDao;
    }

    /**
     * Get user
     * @param $userName
     * @throws ServiceException
     * @return User
     */
    public function getUserByName($userName=NULL) {
        $authenticationDao = $this->getAuthenticationDao();
        try {
            return $authenticationDao->getUserByName($userName);
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Get user type list
     * @throws ServiceException
     * @return UserType list
     */
    public function getUserTypeList() {
        $authenticationDao = $this->getAuthenticationDao();
        try {
            return $authenticationDao->getUserTypeList();
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Add new user
     * @param $userName,$password,$user_type
     * @throws ServiceException
     * @return User
     */
    public function addUser($userName, $password, $user_type) {

        $authenticationDao = $this->getAuthenticationDao();

        try {
            $user = new User();
            $user->setLoginName($userName);
            $user->setPassword(md5($password));
            $user->setUserTypeId($user_type);

            $res = $authenticationDao->addUser($user);
            return $res;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }
}