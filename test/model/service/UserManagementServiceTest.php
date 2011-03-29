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
    public function testAddUser() {
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

            $result = $this->userManagementService->addUser($testCase['login_name'], $testCase['password'], $testCase['user_type_id']);
            $this->assertTrue($result instanceof User);
            $this->assertEquals($user, $result);
        }
    }

    /**
     * Test Add user exception
     */
    public function testAddUserException() {
        try {
            $this->userManagementDao = $this->getMock('UserManagementDao');
            $this->userManagementDao->expects($this->once())
                    ->method('addUser')
                    ->will($this->throwException(New DaoException()));

            $this->userManagementService->setUserManagementDao($this->userManagementDao);
            $result = $this->userManagementService->addUser('user_name', 'password', 'ADMIN');
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test add user language method.
     */
    public function testAddUserLanguage() {
        foreach ($this->testCases['UserLanguage'] as $key => $testCase) {
            $userLang = new UserLanguage();
            $userLang->setUserId($testCase['user_id']);
            $userLang->setLanguageId($testCase['language_id']);

            $this->userManagementDao = $this->getMock('userManagementDao');
            $this->userManagementDao->expects($this->once())
                    ->method('addUserLang')
                    ->will($this->returnValue($userLang));

            $this->userManagementService->setUserManagementDao($this->userManagementDao);

            $result = $this->userManagementService->addUserLang($userLang);
            $this->assertTrue($result instanceof UserLanguage);
            $this->assertEquals($userLang, $result);
        }
    }

    /**
     * Test add User Language Exception.
     */
    public function testAddUserLanguageException() {
        try {
            $this->userManagementDao = $this->getMock('UserManagementDao');
            $this->userManagementDao->expects($this->once())
                    ->method('addUserLang')
                    ->will($this->throwException(New DaoException()));

            $this->userManagementService->setUserManagementDao($this->userManagementDao);

            $userLang = new UserLanguage();
            $userLang->setUserId(0);
            $userLang->setLanguageId(1);

            $result = $this->userManagementService->addUserLang($userLang);
        } catch (Exception $ex) {
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Get User type list
     */
    public function testGetUserTypeList() {

        $this->userManagementDao = $this->getMock('UserManagementDao');
        $this->userManagementDao->expects($this->once())
                ->method('getDataList')
                ->will($this->returnValue(Doctrine_Collection));

        $this->userManagementService->setUserManagementDao($this->userManagementDao);
        $result = $this->userManagementService->getUserTypeList();
        $this->assertTrue(true);
    }

    /**
     * Test Get user type list exception.
     */
    public function testGetUserTypeListException() {

        try {

            $this->userManagementDao = $this->getMock('UserManagementDao');
            $this->userManagementDao->expects($this->once())
                    ->method('getDataList')
                    ->will($this->throwException(New DaoException()));

            $this->userManagementService->setUserManagementDao($this->userManagementDao);

            $result = $this->userManagementService->getUserTypeList();
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Get user Language list.
     */
    public function testGetUserLanguageList() {
        $this->userManagementDao = $this->getMock('UserManagementDao');
        $this->userManagementDao->expects($this->once())
                ->method('getUserLanguageList')
                ->will($this->returnValue(Doctrine_Collection));

        $this->userManagementService->setUserManagementDao($this->userManagementDao);
        $result = $this->userManagementService->getUserLanguageList(2);
        $this->assertTrue(true);
    }

    /**
     * Test user language list exception.
     */
    public function testGetUserLanguageListException() {
        try {

            $this->userManagementDao = $this->getMock('UserManagementDao');
            $this->userManagementDao->expects($this->once())
                    ->method('getUserLanguageList')
                    ->will($this->throwException(New DaoException()));

            $this->userManagementService->setUserManagementDao($this->userManagementDao);

            $result = $this->userManagementService->getUserLanguageList(new UserLanguage());
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Get Language list .
     */
    public function testGetLanguageList() {
        $this->userManagementDao = $this->getMock('UserManagementDao');
        $this->userManagementDao->expects($this->once())
                ->method('getDataList')
                ->will($this->returnValue(Doctrine_Collection));

        $this->userManagementService->setUserManagementDao($this->userManagementDao);
        $result = $this->userManagementService->getLanguageList();
        $this->assertTrue(true);
    }

    /**
     * Test Get Language list Exception.
     */
    public function testGetLanguageListException() {
        try {

            $this->userManagementDao = $this->getMock('UserManagementDao');
            $this->userManagementDao->expects($this->once())
                    ->method('getDataList')
                    ->will($this->throwException(New DaoException()));

            $this->userManagementService->setUserManagementDao($this->userManagementDao);

            $result = $this->userManagementService->getLanguageList();
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test get user by Id method.
     */
    public function testGetUserById() {
        $this->userManagementDao = $this->getMock('UserManagementDao');
        $this->userManagementDao->expects($this->once())
                ->method('getUserById')
                ->will($this->returnValue(new User()));

        $this->userManagementService->setUserManagementDao($this->userManagementDao);
        $result = $this->userManagementService->getUserById(1);
        $this->assertTrue(true);
    }

    /**
     * Test get user by Id Exception.
     */
    public function testGetByIdException() {
        try {

            $this->userManagementDao = $this->getMock('UserManagementDao');
            $this->userManagementDao->expects($this->once())
                    ->method('getUserById')
                    ->will($this->throwException(New DaoException()));

            $this->userManagementService->setUserManagementDao($this->userManagementDao);

            $result = $this->userManagementService->getUserById(1);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

}
