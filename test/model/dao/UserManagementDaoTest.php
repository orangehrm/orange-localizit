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
    private $userManagementDao;

    /**
     * getter method for userManagement.
     * @return <type>
     */
    public function getUserManagement() {
        $this->userManagementDao = new UserManagementDao();
        return $this->userManagementDao;
    }

    /**
     * Setup method
     */
    public function setup() {
        $configuration = ProjectConfiguration::getApplicationConfiguration('localizit', 'test', true);
        $this->testCases = sfYaml::load(sfConfig::get('sf_test_dir') . '/fixtures/userManagement/userManagement.yml');
        $this->userManagementDao = $this->getUserManagement();
        TestDataService::populate(sfConfig::get('sf_test_dir') . '/fixtures/userManagement/userManagement.yml');
    }

    /**
     * Adding Test class for saving records.
     */
    public function testAddNewUser() {
        $newUser = new User();
        $newUser->setLoginName('testuser1');
        $newUser->setPassword(md5('password123'));
        $newUser->setUserTypeId(1);

        $saveUser = $this->userManagementDao->addUser($newUser);
        $result = ($saveUser instanceof User) ? true : false;
        $this->assertTrue($result);
        $this->assertEquals($saveUser['login_name'], 'testuser1');
    }

    /**
     * Test Add user with Exception
     */
    public function testAddNewUserEx() {

        try {
            $newUser = new User();
            $newUser->setUserId(1);
            $newUser->setLoginName('testuser1');
            $newUser->setPassword(md5('password123'));
            $newUser->setUserTypeId(1);

            $userCreated = $this->userManagementDao->addUser($newUser);
        } catch (Exception $ex) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
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
            $saveUser = $this->userManagementDao->addUser($newUser);
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
            $saveUser = $this->userManagementDao->addUser($newUser);
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
            $saveUser = $this->userManagementDao->addUser($newUser);
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

        $result = $this->userManagementDao->updateUser($updateUser);
        $this->assertTrue($result === true);
    }

    /**
     * Delete User
     */
    public function testDeleteUser() {
        foreach ($this->testCases['User'] as $key => $testCase) {
            $result = $this->userManagementDao->deleteUser($testCase['user_id']);
            $this->assertTrue($result);
        }
    }

    /**
     * Test Delete User with exception
     */
    public function testDeleteUserException() {
        try {
            $illegal = array('%', '-', '.');
            $this->userManagementDao->deleteUser($illegal);
        } catch (Exception $ex) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Add User Language method.
     */
    public function testAddUserLang() {
        $userLang = new UserLanguage();
        $userLang->setUserId(2);
        $userLang->setLanguageId(1);

        $saveUserLang = $this->userManagementDao->addUserLang($userLang);

        $result = ($saveUserLang instanceof UserLanguage) ? true : false;
        $this->assertTrue($result);
        $this->assertEquals($saveUserLang['user_id'], 2);
    }

    /**
     * Test Add User Language  Exception
     */
    public function testAddUserLangEx() {
        try {
            $userLang = new UserLanguage();
            $userLang->setId(2);
            $userLang->setUserId(2);
            $userLang->setLanguageId(1);

            $saveUserLang = $this->userManagementDao->addUserLang($userLang);
        } catch (Exception $ex) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Add User Lang without user id
     */
    public function testNullUserId() {

        $newUser = new User();
        $newUser->setUserId(4);
        $newUser->setLoginName('testUser2');
        $newUser->setPassword(md5('password2'));
        $newUser->setUserTypeId(-1);

        try {
            $saveUser = $this->userManagementDao->addUser($newUser);
            //If success fully inserted, then that's a failure.
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertTrue(true);
        }
    }

    /**
     * Test update user with exception.
     */
    public function testUpdateUserException() {
        try {
            $user = new User();
            $user->setUserId(1);
            $user->setLoginName(new User());
            $user->setPassword(NULL);
            $user->setUserTypeId(NULL);

            $updateUser = $this->userManagementDao->updateUser($user);
        } catch (Exception $ex) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Get User by id
     */
    public function testGetUserById() {
        foreach ($this->testCases['User'] as $key => $testCase) {
            $result = $this->userManagementDao->getUserById($testCase['user_id']);
            $this->assertTrue($result instanceof User);
            $this->assertEquals($result->getLoginName(), $testCase['login_name']);
        }
    }

    /**
     * Test Get user Id by exception
     */
    public function testGetUserByIdException() {
        try {
            $illegal = array('%', '-', '.');
            $user = $this->userManagementDao->getUserById($illegal);
        } catch (Exception $ex) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Get Data List
     */
    public function testGetDataList() {
        $result = $this->userManagementDao->getDataList('User');
        $this->assertTrue(($result instanceof Doctrine_Collection));
    }

    /**
     * Test get User Data List Exception.
     */
    public function testGetDataListException() {
        try {
            $user = $this->userManagementDao->getDataList(NULL);
        } catch (Exception $ex) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test get user language list method.
     */
    public function testGetUserLanguageList() {
        $result = $this->userManagementDao->getUserLanguageList(1);
        $this->assertTrue(($result instanceof Doctrine_Collection));
    }

    /**
     * Test get user language list exception
     */
    public function testGetUserLanguageListException() {
        try {
            $illegal = array('%', '-', '.');
            $user = $this->userManagementDao->getUserLanguageList($illegal);
        } catch (Exception $ex) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Delete User Languages
     */
    public function testDeleteUserLanguage() {
        foreach ($this->testCases['UserLanguage'] as $key => $testCase) {
            $result = $this->userManagementDao->deleteUserLanguages($testCase['user_id']);
            $this->assertTrue($result);
        }
    }

    /**
     * Test Delete User Language Exception
     */
    public function testDeleteUserLanguageException() {
        try {
            $illegal = array('%', '-', '.');
            $this->userManagementDao->deleteUserLanguages($illegal);
        } catch (Exception $ex) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

}