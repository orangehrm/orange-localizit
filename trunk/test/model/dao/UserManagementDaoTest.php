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
 * Description of UserManagementDasTest
 *
 * @author waruni
 */
require_once 'PHPUnit/Framework.php';

class UserManagementDaoTest extends PHPUnit_Framework_TestCase {

    /**
     * Define Variables.
     * @var <type>
     */
    private $userManagement;

    /**
     * getter method for userManagement.
     * @return <type>
     */
    public function getUserManagement() {
        $this->userManagement = new UserManagementDao();
        return $this->userManagement;
    }

    /**
     * Setup method
     */
    public function setup() {
        $configuration = ProjectConfiguration::getApplicationConfiguration('localizit', 'test', true);
        $this->testCases = sfYaml::load(sfConfig::get('sf_test_dir') . '/fixtures/userManagement/userManagement.yml');
        $this->userManagement = $this->getUserManagement();
        TestDataService::populate(sfConfig::get('sf_test_dir') . '/fixtures/userManagement/userManagement.yml');
    }

    /**
     * Adding Test class for saving records.
     */
    public function testAddNewUser() {
        $newUser = new User();
        $newUser->setUserId(2);
        $newUser->setLoginName('testuser1');
        $newUser->setPassword(md5('password123'));
        $newUser->setUserTypeId(1);

        $saveUser = $this->userManagement->addUser($newUser);
        $result = ($saveUser instanceof User) ? true : false;
        $this->assertTrue($result);
        $this->assertEquals($saveUser['login_name'], 'testuser1');
    }

    /**
     * Try to save without username
     */
    public function testNullLoginName() {
        $newUser = new User();
        $newUser->setUserId(3);
        $newUser->setLoginName('');
        $newUser->setPassword(md5('password123'));
        $newUser->setUserTypeId(1);

        try {
            $saveUser = $this->userManagement->addUser($newUser);
            //If success fully inserted, then that's a failure.
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * Try to save with out password
     */
    public function testNullPassword() {

        $newUser = new User();
        $newUser->setUserId(4);
        $newUser->setLoginName('testUser2');
        $newUser->setPassword('');
        $newUser->setUserTypeId(1);

        try {
            $saveUser = $this->userManagement->addUser($newUser);
            //If success fully inserted, then that's a failure.
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * Try to save without user type
     */
    public function testNullUserType() {
        $newUser = new User();
        $newUser->setUserId(4);
        $newUser->setLoginName('testUser2');
        $newUser->setPassword(md5('password2'));
        $newUser->setUserTypeId(-1);

        try {
            $saveUser = $this->userManagement->addUser($newUser);
            //If success fully inserted, then that's a failure.
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * Test update user method.
     */
    public function testUserUpdate() {
        $updateUser = new User();
        $updateUser->setUserId(1);
        $updateUser->setLoginName('testuser123');
        $updateUser->setPassword(md5('passwordUpdated'));
        $updateUser->setUserTypeId(1);

        $result = $this->userManagement->updateUser($updateUser);
        $this->assertTrue($result === true);
    }

    /**
     * Delete User
     */
    public function testDeleteUser() {
        foreach ($this->testCases['User'] as $key => $testCase) {
            $result = $this->userManagement->deleteUser($testCase['user_id']);
            $this->assertTrue($result);
        }
    }

}