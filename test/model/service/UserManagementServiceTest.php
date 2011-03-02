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
 * Description of UserManagementServiceTest
 *
 * @author waruni
 */
require_once 'PHPUnit/Framework.php';
class UserManagementServiceTest extends PHPUnit_Framework_TestCase {

    /**
     * Setup Method.
     */
    public function setup() {
        $this->userManagementService = new UserManagementService();
        $this->testCases = sfYaml::load(sfConfig::get('sf_test_dir') . '/fixtures/userManagement/userManagement.yml');
    }

    /**
     * Test Add User
     */

    public function testAddUser(){
        foreach ($this->testCases['User'] as $key => $testCase) {
            $user = new User();
            $user->setLoginName($testCase['login_name']);
            $user->setPassword($testCase['password']);
            $user->setUserTypeId($testCase['user_type_id']);
            
            $this->userManagementDao = $this->getMock('userManagementDao');
            $this->userManagementDao->expects($this->once())
                    ->method('addUser')
                    ->will($this->returnValue($user));

            $this->userManagementService->setUserManagementDao($this->userManagementDao);

            $result = $this->userManagementService->addUser($testCase['login_name'], $testCase['password'],$testCase['user_type_id'] );
            $this->assertTrue($result instanceof User);
            $this->assertEquals($user, $result);
        }
    }
}
