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
 * Authentication Dao Test class
 *
 * @author Chameera S
 */
require_once 'PHPUnit/Framework.php';

class AuthenticationDaoTest extends PHPUnit_Framework_TestCase {

    private $testCases;
    private $authenticationDao;

    /**
     * PHPUnit setup function
     */
    public function setup() {

        $configuration = ProjectConfiguration::getApplicationConfiguration('localizit', 'test', true);
        $this->testCases = sfYaml::load(sfConfig::get('sf_test_dir') . '/fixtures/authentication/authentication.yml');
        $this->authenticationDao = new AuthenticationDao();
        TestDataService::populate(sfConfig::get('sf_test_dir') . '/fixtures/authentication/authentication.yml');
    }

    /**
     * Test Get User By Name
     *
     */
    public function testGetUserByName() {
        foreach ($this->testCases['User'] as $key => $testCase) {
            $result = $this->authenticationDao->getUserByName($testCase['login_name']);

            $this->assertTrue($result instanceof User);

            //check passwords
            $this->assertEquals($result->password, md5($testCase['password']));
        }
    }

    /**
     * Test Get User By null User Name
     *
     */
    public function testGetUserByNullName() {
        $result = $this->authenticationDao->getUserByName();
        $this->assertFalse($result);
    }

    /**
     * Test Get User By not exist User Name
     *
     */
    public function testGetUserByInvalidName() {
        $result = $this->authenticationDao->getUserByName('invalid_user');
        $this->assertFalse($result);
    }

}
