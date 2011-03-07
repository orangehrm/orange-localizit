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
 * User Role Test class
 *
 * @author Chameera S
 */
require_once 'PHPUnit/Framework.php';

class UserRoleTest extends PHPUnit_Framework_TestCase {

    private $userRole;
    private $userManagementService;

    /**
     * PHPUnit setup function
     */
    public function setup() {

        $this->userRole = new UserRole();
    }

    /**
     * Test Admin User Role
     *
     */
    public function testAdmin() {
        $_SERVER['session_id'] = 'test';
        $dispatcher = new sfEventDispatcher();
        $sessionPath = sys_get_temp_dir() . '/sessions_' . rand(11111, 99999);
        $storage = new sfSessionTestStorage(array('session_path' => $sessionPath));

        $sfUser = new myUser($dispatcher, $storage);
        $sfUser->login_name = 'test_user';
        $sfUser->password = md5('password');
        $sfUser->setAuthenticated(true);
        $sfUser->addCredential('Admin');

        $user = new User();
        $user->user_id = '1';
        $user->login_name = 'test_user';
        $user->password = md5('password');

        $this->userRole->setSfUser($sfUser);
        $this->userRole->setUser($user);

        $langIds = array();
        $langList = array();

        for ($i=1; $i<6; $i++ ) {
            $lang = new Language();
            $lang->setLanguageId($i);
            $lang->setLanguageCode('language_code'.$i);
            $lang->setLanguageName('language_name'.$i);
            $lang->setLanguageStatus(0);
            array_push($langList, $lang);
            array_push($langIds, $i);
        }


        $this->userManagementService = $this->getMock('UserManagementService');
        $this->userManagementService->expects($this->any())
                ->method('getLanguageList')
                ->will($this->returnValue($langList));

        $result = array();

        foreach ($this->userRole->getUserRoleDecorator() as $roleDecorator) {
            $roleDecorator->setUserManagementService($this->userManagementService);
            $result = array_merge($result, $roleDecorator->getAllowedLanguageList());
        }

        $this->assertTrue($this->userRole->isAllowedToManageUser());
        $this->assertTrue($this->userRole->isAllowedToDownloadDirectory());
        $this->assertTrue($this->userRole->isAllowedToAddLabel());
        $this->assertEquals($result, $langIds);
    }

    /**
     * Test Moderator User Role
     *
     */
    public function testModerator() {
        $_SERVER['session_id'] = 'test';
        $dispatcher = new sfEventDispatcher();
        $sessionPath = sys_get_temp_dir() . '/sessions_' . rand(11111, 99999);
        $storage = new sfSessionTestStorage(array('session_path' => $sessionPath));

        $sfUser = new myUser($dispatcher, $storage);
        $sfUser->login_name = 'test_user';
        $sfUser->password = md5('password');
        $sfUser->setAuthenticated(true);
        $sfUser->addCredential('Moderator');

        $user = new User();
        $user->user_id = '1';
        $user->login_name = 'test_user';
        $user->password = md5('password');

        $this->userRole->setSfUser($sfUser);
        $this->userRole->setUser($user);

        $langIds = array();
        $langList = array();

        for ($i=1; $i<4; $i++ ) {
            $lang = new Language();
            $lang->setLanguageId($i);
            $lang->setLanguageCode('language_code'.$i);
            $lang->setLanguageName('language_name'.$i);
            $lang->setLanguageStatus(0);
            array_push($langList, $lang);
            array_push($langIds, $i);
        }


        $this->userManagementService = $this->getMock('UserManagementService');
        $this->userManagementService->expects($this->any())
                ->method('getUserLanguageList')
                ->will($this->returnValue($langList));

        $result = array();

        foreach ($this->userRole->getUserRoleDecorator() as $roleDecorator) {
            $roleDecorator->setUserManagementService($this->userManagementService);
            $result = array_merge($result, $roleDecorator->getAllowedLanguageList());
        }      

        $this->assertTrue(!$this->userRole->isAllowedToManageUser());
        $this->assertTrue($this->userRole->isAllowedToDownloadDirectory());
        $this->assertTrue(!$this->userRole->isAllowedToAddLabel());
        $this->assertEquals($result, $langIds);
         
    }

    /**
     * Test Moderator User Role with setter geter
     *
     */
    public function testModerator2() {
        $_SERVER['session_id'] = 'test';
        $dispatcher = new sfEventDispatcher();
        $sessionPath = sys_get_temp_dir() . '/sessions_' . rand(11111, 99999);
        $storage = new sfSessionTestStorage(array('session_path' => $sessionPath));

        $sfUser = new myUser($dispatcher, $storage);
        $sfUser->login_name = 'test_user';
        $sfUser->password = md5('password');
        $sfUser->setAuthenticated(true);
        $sfUser->addCredential('Moderator');

        $user = new User();
        $user->user_id = '1';
        $user->login_name = 'test_user';
        $user->password = md5('password');

        $this->userRole->setSfUser($sfUser);
        $this->userRole->setUser($user);

        $langIds = array();
        $langList = array();

        for ($i=1; $i<4; $i++ ) {
            $lang = new Language();
            $lang->setLanguageId($i);
            $lang->setLanguageCode('language_code'.$i);
            $lang->setLanguageName('language_name'.$i);
            $lang->setLanguageStatus(0);
            array_push($langList, $lang);
            array_push($langIds, $i);
        }

        $this->userRole->setUserRoleDecoratorFactory(new UserRoleDecoratorFactory());


        $this->userManagementService = $this->getMock('UserManagementService');
        $this->userManagementService->expects($this->any())
                ->method('getUserLanguageList')
                ->will($this->returnValue($langList));

        $result = array();

        foreach ($this->userRole->getUserRoleDecorator() as $roleDecorator) {
            $roleDecorator->setUserManagementService($this->userManagementService);
            $result = array_merge($result, $roleDecorator->getAllowedLanguageList());
        }

        $this->assertTrue(!$this->userRole->isAllowedToManageUser());
        $this->assertTrue($this->userRole->isAllowedToDownloadDirectory());
        $this->assertTrue(!$this->userRole->isAllowedToAddLabel());
        $this->assertEquals($result, $langIds);

    }

    /**
     * Test invalid User
     *
     */
    public function testInvalidUser() {
        $_SERVER['session_id'] = 'test';
        $dispatcher = new sfEventDispatcher();
        $sessionPath = sys_get_temp_dir() . '/sessions_' . rand(11111, 99999);
        $storage = new sfSessionTestStorage(array('session_path' => $sessionPath));

        $sfUser = new myUser($dispatcher, $storage);
        $sfUser->login_name = 'test_user';
        $sfUser->password = md5('password');
        $sfUser->setAuthenticated(true);
        $sfUser->addCredential('null');

        $langIds = array();
        $langList = array();

        for ($i=1; $i<4; $i++ ) {
            $lang = new Language();
            $lang->setLanguageId($i);
            $lang->setLanguageCode('language_code'.$i);
            $lang->setLanguageName('language_name'.$i);
            $lang->setLanguageStatus(0);
            array_push($langList, $lang);
            array_push($langIds, $i);
        }

        $this->userRole->setUserRoleDecoratorFactory(new UserRoleDecoratorFactory());


        $this->userManagementService = $this->getMock('UserManagementService');
        $this->userManagementService->expects($this->any())
                ->method('getUserLanguageList')
                ->will($this->returnValue($langList));

        $result = array();

        foreach ($this->userRole->getUserRoleDecorator() as $roleDecorator) {
            $roleDecorator->setUserManagementService($this->userManagementService);
            $result = array_merge($result, $roleDecorator->getAllowedLanguageList());
        }

        $this->assertTrue(!$this->userRole->isAllowedToManageUser());
        $this->assertTrue($this->userRole->isAllowedToDownloadDirectory());
        $this->assertTrue(!$this->userRole->isAllowedToAddLabel());
        $this->assertEquals($result, array());

    }

    /**
     * Test Normal User Role
     *
     */
    public function testNormal() {

        $this->userRole->setSfUser(null);

        foreach ($this->userRole->getUserRoleDecorator() as $roleDecorator) {
            $roleDecorator->getUserManagementService();
        }

        $this->assertTrue(!$this->userRole->isAllowedToManageUser());
        $this->assertTrue($this->userRole->isAllowedToDownloadDirectory());
        $this->assertTrue(!$this->userRole->isAllowedToAddLabel());
        $this->assertEquals($this->userRole->getAllowedLanguageList(), array());
    }
}
