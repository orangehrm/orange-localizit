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
            // instantiate User object
            $user = new User();
            $user->login_name = $testCase['login_name'];
            $user->password = md5($testCase['password']);

            $this->authenticationDao = $this->getMock('AuthenticationDao');
            $this->authenticationDao->expects($this->once())
                    ->method('getUserByName')
                    ->will($this->returnValue($user));

            $this->authenticationService->setAuthenticationDao($this->authenticationDao);

            $result = $this->authenticationService->getUserByName($testCase['login_name']);

            $this->assertTrue($result instanceof User);

            //check passwords
            $this->assertEquals($result->password, md5($testCase['password']));
        }
    }

    /**
     * Test Get User by Null Name
     *
     */
    public function testGetUserByNullName() {

            $this->authenticationDao = $this->getMock('AuthenticationDao');
            $this->authenticationDao->expects($this->once())
                    ->method('getUserByName')
                    ->will($this->returnValue(NULL));

            $this->authenticationService->setAuthenticationDao($this->authenticationDao);

            $result = $this->authenticationService->getUserByName();

            $this->assertNull($result);
    }
}
