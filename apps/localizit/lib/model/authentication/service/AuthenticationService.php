<?php

/*
 *
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
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
    public function getUserByName($userName) {
        $authenticationDao = $this->getAuthenticationDao();
        try {
            return $authenticationDao->getUserByName($userName);
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Get User
     * @param <type> $userName
     * @param <type> $password
     * @return <type> user
     */

    public function getUser($userName, $password) {
        $authenticationDao = $this->getAuthenticationDao();
        try {
            return $authenticationDao->getUser($userName, $password);
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

}