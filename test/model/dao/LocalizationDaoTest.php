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

class LocalizationDaoTest  extends  PHPUnit_Framework_TestCase {

    private $testCases;
    private $localizationDao;

    /**
     * PHPUnit setup function
     */
    public function setup() {

        $configuration 		= ProjectConfiguration::getApplicationConfiguration('localizit', 'test', true);
        $this->testCases 	= sfYaml::load(sfConfig::get('sf_test_dir') . '/fixtures/localization/localization.yml');
        $this->localizationDao	=	new LocalizationDao();

    }

    /**
     * Test Save Label
     *
     */
    public function testAddLabel() {

        foreach ($this->testCases['Label'] as $key=>$testCase) {
            $label	=	new Label();
            $label->setLabelName( $testCase['label_name']);
            $label->setLabelComment( $testCase['label_comment']);
            $label->setLabelStatus( $testCase['label_status']);

            $labelCreated	=	$this->localizationDao->addLabel( $label );
            $result	=   ($labelCreated instanceof Label)?true:false;
            $this->assertTrue($result);

            $this->testCases['Label'][$key]["label_id"] =  $labelCreated->getLabelId();
            $this->testCases['Label_Duplicate'][$key]["label_id"] =  $labelCreated->getLabelId();

        }

        file_put_contents(sfConfig::get('sf_test_dir') . '/fixtures/localization/localization.yml',sfYaml::dump($this->testCases));
    }

    /**
     * Test Save Label - Negative
     *  Try to save duplicate label
     */
    public function testAddLabelNegative() {

        foreach ($this->testCases['Label'] as $key=>$testCase) {
            try {
                $label	=	new Label();
                $label->setLabelName( $testCase['label_name']);
                $label->setLabelComment( $testCase['label_comment']);
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
     * Test Upsate Label
     *
     */
    public function testUpdateLabel() {

        foreach ($this->testCases['Label'] as $key=>$testCase) {
            $label	=	new Label();
            $label->setLabelId( $testCase['label_id']);
            $label->setLabelName( $testCase['label_name'].rand(1,1000));
            $label->setLabelComment( $testCase['label_comment']);
            $label->setLabelStatus( $testCase['label_status']);

            $labelUpdated	=	$this->localizationDao->updateLabel( $label );

            $this->assertTrue(($labelUpdated===true) || ($labelCreated===false));
           
            $this->testCases['Label'][$key]["label_name"] =  $label->getLabelName();

        }

        file_put_contents(sfConfig::get('sf_test_dir') . '/fixtures/localization/localization.yml',sfYaml::dump($this->testCases));        
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
            $this->assertTrue($result instanceof Label);
        }
    }

    /**
     * Test Get Label By Id - Negative
     * Try to retrive unavailable label
     */
    public function testGetLabelByIdNegative() {
        foreach ($this->testCases['Label_Negative'] as $key=>$testCase) {
            $result	=	$this->localizationDao->getLabelById( $testCase['label_id'] );
            $this->assertTrue($result===false);
        }
    }

    /**
     * Test Get Label By Name
     *
     */
    public function testGetLabelByName() {
        foreach ($this->testCases['Label'] as $key=>$testCase) {
            $result	=	$this->localizationDao->getLabelByName( $testCase['label_name'] );
            $this->assertTrue($result instanceof Label);
        }
    }

    /**
     * Test Get Label By Name - Negative
     * Try to retrive unavailable label
     */
    public function testGetLabelByNameNegative() {
        foreach ($this->testCases['Label_Negative'] as $key=>$testCase) {
            $result	=	$this->localizationDao->getLabelByName( $testCase['label_name'] );
            $this->assertTrue($result===false);
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

    /**
     * Test Get Language By Id
     *
     */
    public function testGetLanguagelById() {
        foreach ($this->testCases['Language'] as $key=>$testCase) {
            $result	=	$this->localizationDao->getLanguageById($testCase['language_id']);
            $this->assertTrue($result instanceof Language);
        }
    }

    /**
     * Test Get Language By Id - Negative
     *  Try to retrive unavailable languages
     */
    public function testGetLanguagelByIdNegative() {
        foreach ($this->testCases['Language_Negative'] as $key=>$testCase) {
            $result	=	$this->localizationDao->getLanguageById($testCase['language_id']);
            $this->assertTrue($result===false);
        }
    }

    /**
     * Test Get Language List
     *
     */
    public function testGetLanguagelByCode() {
        foreach ($this->testCases['Language'] as $key=>$testCase) {
            $result	=	$this->localizationDao->getLanguageByCode($testCase['language_code']);
            $this->assertTrue($result instanceof Language);
        }
    }

    /**
     * Test Get Language By Id - Negative
     *  Try to retrive unavailable languages
     */
    public function testGetLanguagelByCodeNegative() {
        foreach ($this->testCases['Language_Negative'] as $key=>$testCase) {
            $result	=	$this->localizationDao->getLanguageByCode($testCase['language_code']);
            $this->assertTrue($result===false);
        }
    }

    /**
     * Test Add language string
     *
     */
    public function testAddLanStr() {
        foreach ($this->testCases['Language_strings'] as $key=>$testCase) {
            $languageLabelString	=	new LanguageLabelString();
            $languageLabelString->setLabelId(  $this->testCases['Label'][$key]['label_id']);
            $languageLabelString->setLanguageId( $this->testCases['Language']['data1']['language_id']);
            $languageLabelString->setLanguageLabelString( $testCase['language_label_string']);
            $languageLabelString->setLanguageLabelStringStatus( $testCase['language_label_string_status']);

            $languageLabelStringCreated	=	$this->localizationDao->addLangStr( $languageLabelString );
            $result	=   ($languageLabelStringCreated instanceof LanguageLabelString)?true:false;
            $this->assertTrue($result);

            $this->testCases['Language_strings'][$key]["language_label_string_id"] =  $languageLabelStringCreated->getLanguageLabelStringId();            

        }

        file_put_contents(sfConfig::get('sf_test_dir') . '/fixtures/localization/localization.yml',sfYaml::dump($this->testCases));
    }

    /**
     * Test Add language string - Negative
     *  Trying to create a language string with same Label Id + Language Id + Language String
     */
    public function testAddLanStrNegative() {
        foreach ($this->testCases['Language_strings'] as $key=>$testCase) {

            try {
                $languageLabelString	=	new LanguageLabelString();
                $languageLabelString->setLabelId(  $this->testCases['Label'][$key]['label_id']);
                $languageLabelString->setLanguageId( $this->testCases['Language']['data1']['language_id']);
                $languageLabelString->setLanguageLabelString( $testCase['language_label_string']);
                $languageLabelString->setLanguageLabelStringStatus( $testCase['language_label_string_status']);

                $this->localizationDao->addLangStr( $languageLabelString );
                //Label Id + Language Id + Language String must be uniq.
                //This should not get inserted
                $this->assertTrue(false);

            }catch(Exception $ex) {
                //This error must occures
                $this->assertTrue(true);
            }
        }
    }

    /**
     * Test Add language string
     *
     */
    public function testUpdateLanStr() {
        foreach ($this->testCases['Language_strings'] as $key=>$testCase) {
            $languageLabelString	=	new LanguageLabelString();
            $languageLabelString->setLanguageLabelStringId($testCase['language_label_string_id']);
            $languageLabelString->setLabelId(  $this->testCases['Label'][$key]['label_id']);
            $languageLabelString->setLanguageId( $this->testCases['Language']['data1']['language_id']);
            $languageLabelString->setLanguageLabelString( $testCase['language_label_string'].rand(1,1000));
            $languageLabelString->setLanguageLabelStringStatus( $testCase['language_label_string_status']);

            $languageLabelStringUpdated	=	$this->localizationDao->updateLangStr( $languageLabelString );
            $this->assertTrue(($languageLabelStringUpdated===true) || ($languageLabelStringUpdated===false));
        }
    }

    /**
     * Test Get language string list by source and target Language Id
     *
     */
    public function testGetLangStrBySrcAndTargetIds() {
        foreach ($this->testCases['Language_strings_retrive'] as $key=>$testCase) {
            $result	=	$this->localizationDao->
                    getLangStrBySrcAndTargetIds($testCase['source_language_id'],$testCase['target_language_id']);
            $this->assertTrue(($result instanceof Doctrine_Collection) || ($result->count()==false));
        }
    }
}
