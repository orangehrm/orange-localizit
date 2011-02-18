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
 * Authentication Service Test class
 *
 * @author Chameera S
 */
require_once 'PHPUnit/Framework.php';

class AuthenticationServiceTest extends PHPUnit_Framework_TestCase {

    private $testCases;
    private $authenticationService;
    private $authenticationDao;

    /**
     * PHPUnit setup function
     */
    public function setup() {
        $this->authenticationService = new AuthenticationService();
        $this->testCases = sfYaml::load(sfConfig::get('sf_test_dir') . '/fixtures/authentication/authentication.yml');
    }

    /**
     * Test Get User by Name
     *
     */
    public function testGetUserByName() {
        foreach ($this->testCases['User'] as $key => $testCase) {
            $this->authenticationDao = $this->getMock('AuthenticationDao');
            $this->authenticationDao->expects($this->once())
                    ->method('getUserByName')
                    ->will($this->returnValue(Doctrine_Collection));

            $this->authenticationService->setAuthenticationDao($this->authenticationDao);

            $result = $this->authenticationService->getUserByName($testCase['login_name']);
            $this->assertTrue(true);
        }
    }

    /**
     * Test Get User
     *
     */
    public function testGetUser() {
        foreach ($this->testCases['User'] as $key => $testCase) {
            $this->authenticationDao = $this->getMock('AuthenticationDao');
            $this->authenticationDao->expects($this->once())
                    ->method('getUser')
                    ->will($this->returnValue(Doctrine_Collection));

            $this->authenticationService->setAuthenticationDao($this->authenticationDao);

            $result = $this->authenticationService->getUser( $testCase['login_name'], $testCase['password'] );
            $this->assertTrue(true);
        }
    }
}
