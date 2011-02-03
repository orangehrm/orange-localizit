<?php
/*
 *
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
*/

/**
 * localization Dao Test class
 *
 * @author ruwan
 */

require_once 'PHPUnit/Framework.php';

class localizationDaoTest  extends  PHPUnit_Framework_TestCase {

    private $testCases;
    private $localizationDao;

    /**
     * PHPUnit setup function
     */
    public function setup() {

        $configuration 		= ProjectConfiguration::getApplicationConfiguration('localizit', 'test', false);
        $this->testCases 	= sfYaml::load(sfConfig::get('sf_test_dir') . '/fixtures/localization/localization.yml');
        $this->localizationDao	=	new LocalizationDao();

    }

    /**
     * Test Get All Labels
     *
     */
    public function testGetLabelList() {
        $result	=	$this->localizationDao->getLabelList();
        $this->assertTrue(($result instanceof Doctrine_Collection));
    }

    /**
     * Test Get Label By Id
     *
     */
    public function testGetLabelById() {
        foreach ($this->testCases['Label'] as $key=>$testCase) {
            $result	=	$this->localizationDao->getLabelById( $testCase['label_id'] );
            if(($result instanceof Label) || ($result===false)) {
                $this->assertTrue(true);
            }
        }
    }

    /**
     * Test Get Label By Name
     *
     */
    public function testGetLabelByName() {
        foreach ($this->testCases['Label'] as $key=>$testCase) {
            $result	=	$this->localizationDao->getLabelByName( $testCase['label_name'] );
            if(($result instanceof Label) || ($result===false)) {
                $this->assertTrue(true);
            }
        }
    }

    /**
     * Test Save Label
     *
     */
    public function testAddLabel() {

        foreach ($this->testCases['Label'] as $key=>$testCase) {
            $label	=	new Label();
            $label->setLabelName( $testCase['label_name']);
            $label->setLabelComment( $testCase['label_name']);
            $label->setLabelStatus( $testCase['label_status']);

            $labelCreated	=	$this->localizationDao->addLabel( $label );
            $result	=   ($labelCreated instanceof Label)?true:false;
            $this->assertTrue($result);

            $this->testCases['Label'][$key]["label_id"] =  $labelCreated->getLabelId();
            $this->testCases['Label_Duplicate'][$key]["label_id"] =  $labelCreated->getLabelId();

            //Generating none repeating label names
            $this->testCases['Label'][$key]["label_name"] = $labelCreated->getLabelName().'-'.rand(1, 100000);
            $this->testCases['Label_Duplicate'][$key]["label_name"] = $labelCreated->getLabelName();
        }

        file_put_contents(sfConfig::get('sf_test_dir') . '/fixtures/localization/localization.yml',sfYaml::dump($this->testCases));
    }

    /**
     * Test Save Label with Duplicate entry
     *
     */
    public function testAddLabelNegative() {

        foreach ($this->testCases['Label_Duplicate'] as $key=>$testCase) {
            try {
                $label	=	new Label();
                $label->setLabelName( $testCase['label_name']);
                $label->setLabelComment( $testCase['label_name']);
                $label->setLabelStatus( $testCase['label_status']);

                $labelCreated	=	$this->localizationDao->addLabel( $label );

                //If success fully inserted, then that's a failure.
                
                $this->assertTrue(false);
            }catch (Exception $ex) {
                //Must throw an error
                $this->assertTrue(true);
            }
        }       
    }

    /**
     * Test Get Language List
     *
     */
    public function testGetLanguagelList() {
        $result	=	$this->localizationDao->getLanguageList();
        $this->assertTrue(($result instanceof Doctrine_Collection));
    }
}
