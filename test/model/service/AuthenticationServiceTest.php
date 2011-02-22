<?php

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
