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

        $user = new myUser($dispatcher, $storage);
        $user->login_name = 'test_user';
        $user->password = md5('password');
        $user->setAuthenticated(true);
        $user->addCredential('Admin');

        $this->userRole->setUserRoleDecoratorFactory(new UserRoleDecoratorFactory());

        $langIds = array("language_id" => 1, "language_id" => 2, "language_id" => 3);
        $this->userManagementService = $this->getMock('UserManagementService');
        $this->userManagementService->expects($this->once())
                    ->method('getUserLanguageList')
                    ->will($this->returnValue($langIds));

        foreach($this->userRole->getUserRoleDecorator() as $roleDecorator){
            $roleDecorator->setUserManagementService($this->userManagementService);
        }

        $this->userRole->setSfUser($user);

        $this->assertTrue($this->userRole->isAllowedToManageUser());
        $this->assertTrue($this->userRole->isAllowedToDownloadDirectory());
        $this->assertEquals($this->userRole->getAllowedLanguageList(), $langIds);
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

        $user = new myUser($dispatcher, $storage);
        $user->login_name = 'test_user';
        $user->password = md5('password');
        $user->setAuthenticated(true);
        $user->addCredential('Moderator');

        $langIds = array("language_id" => 1, "language_id" => 2);
        $this->userManagementService = $this->getMock('UserManagementService');
        $this->userManagementService->expects($this->once())
                    ->method('getUserLanguageList')
                    ->will($this->returnValue($langIds));

        foreach($this->userRole->getUserRoleDecorator() as $roleDecorator){
            $roleDecorator->setUserManagementService($this->userManagementService);
        }

        $this->userRole->setSfUser($user);

        $this->assertTrue(!$this->userRole->isAllowedToManageUser());
        $this->assertTrue($this->userRole->isAllowedToDownloadDirectory());
        $this->assertEquals($this->userRole->getAllowedLanguageList(), $langIds);
    }

    /**
     * Test Normal User Role
     *
     */
    public function testNormal() {
        $_SERVER['session_id'] = 'test';
        $dispatcher = new sfEventDispatcher();
        $sessionPath = sys_get_temp_dir() . '/sessions_' . rand(11111, 99999);
        $storage = new sfSessionTestStorage(array('session_path' => $sessionPath));

        $user = new myUser($dispatcher, $storage);
        $user->login_name = 'test_user';
        $user->password = md5('password');
        $user->setAuthenticated(false);

        $this->userRole->setSfUser($user);

        $this->assertTrue(!$this->userRole->isAllowedToManageUser());
        $this->assertTrue($this->userRole->isAllowedToDownloadDirectory());
        $this->assertNull($this->userRole->getAllowedLanguageList());
    }

}
