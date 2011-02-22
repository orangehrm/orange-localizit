<?php

/**
 * Authentication Dao Test class
 *
 * @author Chameera S
 */

require_once 'PHPUnit/Framework.php';

class AuthenticationDaoTest  extends  PHPUnit_Framework_TestCase {

    private $testCases;
    private $authenticationDao;

    /**
     * PHPUnit setup function
     */
    public function setup() {

        $configuration 		= ProjectConfiguration::getApplicationConfiguration('localizit', 'test', true);
        $this->testCases 	= sfYaml::load(sfConfig::get('sf_test_dir') . '/fixtures/authentication/authentication.yml');
        $this->authenticationDao	=	new AuthenticationDao();
        TestDataService::populate (sfConfig::get('sf_test_dir') . '/fixtures/authentication/authentication.yml');

    }

    /**
     * Test Get User By Name
     *
     */
    public function testGetUserByName() {
        foreach ($this->testCases['User'] as $key=>$testCase) {
            $result	=	$this->authenticationDao->getUserByName( $testCase['login_name'] );
            
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
            $result	=	$this->authenticationDao->getUserByName();
            $this->assertNull($result);
    }
    

    /**
     * Test Get User By not exist User Name
     *
     */
    public function testGetUserByInvalidName() {
            $result	=	$this->authenticationDao->getUserByName('invalid_user');
            $this->assertNull($result);
    }
}
