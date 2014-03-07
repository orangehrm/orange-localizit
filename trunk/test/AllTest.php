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

require_once 'PHPUnitVersionHelper.php';

define('ROOT_PATH', dirname(__FILE__) . '/../../');
define('SF_APP_NAME', 'localizit');
define('SF_ENV', 'test');
define('SF_CONN', 'doctrine');

if (!defined('TEST_ENV_CONFIGURED')) {

    require_once(dirname(__FILE__) . '/../config/ProjectConfiguration.class.php');
    AllTests::$configuration = ProjectConfiguration::getApplicationConfiguration(SF_APP_NAME, SF_ENV, true);
    sfContext::createInstance(AllTests::$configuration);

    define('TEST_ENV_CONFIGURED', TRUE);
}

class AllTests {

    public static $configuration = null;
    public static $databaseManager = null;
    public static $connection = null;

    protected function setUp() {

        if (self::$configuration) {
            // initialize database manager
            self::$databaseManager = new sfDatabaseManager(self::$configuration);
            self::$databaseManager->loadConfiguration();

            if (SF_CONN != '') {
                self::$connection = self::$databaseManager->getDatabase(SF_CONN);
            }
        }

    }


    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PHPUnit');

    	// execute functional unit tests
    	/*$coredirfunc = new DirectoryIterator(dirname(__FILE__). '/functional/localizit/');
        while ($coredirfunc->valid()) {
            if (strpos( $coredirfunc, 'Test.php' ) !== false) {
                $suite->addTestFile(  dirname(__FILE__). '/functional/localizit/'. $coredirfunc );
            }
            $coredirfunc->next();
        }*/
        
    	// execute service unit tests
    	$coredir = new DirectoryIterator(dirname(__FILE__). '/model/service/');
        while ($coredir->valid()) {
            if (strpos( $coredir, 'Test.php' ) !== false) {
                $suite->addTestFile(  dirname(__FILE__). '/model/service/'. $coredir );
            }
            $coredir->next();
        }

        // execute dao unit tests
    	$coredirdao = new DirectoryIterator(dirname(__FILE__). '/model/dao/');
        while ($coredirdao->valid()) {
            if (strpos( $coredirdao, 'Test.php' ) !== false) {
                $suite->addTestFile(  dirname(__FILE__). '/model/dao/'. $coredirdao );
            }
            $coredirdao->next();
        }

        // execute user role unit tests
    	$coredirrole = new DirectoryIterator(dirname(__FILE__). '/model/userrole/');
        while ($coredirrole->valid()) {
            if (strpos( $coredirrole, 'Test.php' ) !== false) {
                $suite->addTestFile(  dirname(__FILE__). '/model/userrole/'. $coredirrole );
            }
            $coredirrole->next();
        }

        return $suite;
    }
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

}
