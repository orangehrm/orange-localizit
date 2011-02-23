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
 * localization Dao Test class
 *
 * @author ruwan
 */
require_once 'PHPUnit/Framework.php';

class LocalizationDaoTest extends PHPUnit_Framework_TestCase {

    private $testCases;
    private $localizationDao;

    /**
     * PHPUnit setup function
     */
    public function setup() {

        $configuration = ProjectConfiguration::getApplicationConfiguration('localizit', 'test', true);
        $this->testCases = sfYaml::load(sfConfig::get('sf_test_dir') . '/fixtures/localization/localization_test.yml');
        $this->localizationDao = new LocalizationDao();
        TestDataService::populate(sfConfig::get('sf_test_dir') . '/fixtures/localization/localization_test.yml');
    }

    /**
     * Test Save Label
     *
     */
    public function testAddLabel() {
        $label = new Label();
        $label->setLabelName('test_1');
        $label->setLabelComment('test_1');
        $label->setLabelStatus('test_1');

        $labelCreated = $this->localizationDao->addLabel($label);
        $result = ($labelCreated instanceof Label) ? true : false;
        $this->assertTrue($result);

        $this->assertEquals($this->localizationDao->getLabelByName('test_1')->getLabelComment(), 'test_1');
    }

    /**
     * Test Save Label - Negative
     *  Try to save duplicate label
     */
    public function testAddLabelNegative() {
        try {
            $label = new Label();
            $label->setLabelId(-1);
            $label->setLabelName('test_2');
            $label->setLabelComment('test_2');
            $label->setLabelStatus('test_2');

            $labelCreated = $this->localizationDao->addLabel($label);

            //If success fully inserted, then that's a failure.
            $this->assertTrue(false);
        } catch (Exception $ex) {
            //Must throw an error
            $this->assertTrue(true);
        }
    }

    /**
     * Test Upsate Label
     *
     */
    public function testUpdateLabel() {

        $label = new Label();
        $label->setLabelId(1);
        $label->setLabelName('test_up');
        $label->setLabelComment('test_up');
        $label->setLabelStatus('test_up');

        $labelUpdated = $this->localizationDao->updateLabel($label);

        $this->assertTrue(($labelUpdated === true) || ($labelCreated === false));

        $this->assertEquals($this->localizationDao->getLabelById(1)->getLabelName(), 'test_up');
    }

    /**
     * Test Get All Labels
     *
     */
    public function testGetLabelList() {
        $result = $this->localizationDao->getLabelList();
        $this->assertTrue(($result instanceof Doctrine_Collection));
    }

    /**
     * Test Get Label By Id
     *
     */
    public function testGetLabelById() {
        foreach ($this->testCases['Label'] as $key => $testCase) {
            $result = $this->localizationDao->getLabelById($testCase['label_id']);
            $this->assertTrue($result instanceof Label);
            $this->assertEquals($result->getLabelName(), $testCase['label_name']);
        }
    }

    /**
     * Test Get Label By Id - Negative
     * Try to retrive unavailable label
     */
    public function testGetLabelByIdNegative() {
        $result = $this->localizationDao->getLabelById(-10);
        $this->assertTrue($result === false);
    }

    /**
     * Test Get Label By Name
     *
     */
    public function testGetLabelByName() {
        foreach ($this->testCases['Label'] as $key => $testCase) {
            $result = $this->localizationDao->getLabelByName($testCase['label_name']);
            $this->assertTrue($result instanceof Label);
            $this->assertEquals($result->getLabelId(), $testCase['label_id']);
        }
    }

    /**
     * Test Get Label By Name - Negative
     * Try to retrive unavailable label
     */
    public function testGetLabelByNameNegative() {
        $result = $this->localizationDao->getLabelByName('unknown');
        $this->assertTrue($result === false);
    }

    /**
     * Test Get Language List
     *
     */
    public function testGetLanguagelList() {
        $result = $this->localizationDao->getLanguageList();
        $this->assertTrue(($result instanceof Doctrine_Collection));
    }

    /**
     * Test Get Language By Id
     *
     */
    public function testGetLanguagelById() {
        foreach ($this->testCases['Language'] as $key => $testCase) {
            $result = $this->localizationDao->getLanguageById($testCase['language_id']);
            $this->assertTrue($result instanceof Language);
            $this->assertEquals($result->getLanguageName(), $testCase['language_name']);
        }
    }

    /**
     * Test Get Language By Id - Negative
     *  Try to retrive unavailable languages
     */
    public function testGetLanguagelByIdNegative() {
        $result = $this->localizationDao->getLanguageById(-11);
        $this->assertTrue($result === false);
    }

    /**
     * Test Get Language List
     *
     */
    public function testGetLanguagelByCode() {
        foreach ($this->testCases['Language'] as $key => $testCase) {
            $result = $this->localizationDao->getLanguageByCode($testCase['language_code']);
            $this->assertTrue($result instanceof Language);
            $this->assertEquals($result->getLanguageName(), $testCase['language_name']);
            $this->assertEquals($result->getLanguageId(), $testCase['language_id']);
        }
    }

    /**
     * Test Get Language By Id - Negative
     *  Try to retrive unavailable languages
     */
    public function testGetLanguagelByCodeNegative() {
        $result = $this->localizationDao->getLanguageByCode(-10);
        $this->assertTrue($result === false);
    }

    /**
     * Test Add language string
     *
     */
    public function testAddLanStr() {
        $languageLabelString = new LanguageLabelString();
        $languageLabelString->setLabelId(3);
        $languageLabelString->setLanguageId(3);
        $languageLabelString->setLanguageLabelString('language_label_string');
        $languageLabelString->setLanguageLabelStringStatus('language_label_string_status');

        $languageLabelStringCreated = $this->localizationDao->addLangStr($languageLabelString);
        $result = ($languageLabelStringCreated instanceof LanguageLabelString) ? true : false;
        $this->assertTrue($result);
        $this->assertEquals($languageLabelStringCreated->getLanguageLabelString(), 'language_label_string');
    }

    /**
     * Test Add language string - Negative
     *  Trying to create a language string with same Label Id + Language Id + Language String
     */
    public function testAddLanStrNegative() {
        foreach ($this->testCases['LanguageLabelString'] as $key => $testCase) {

            try {
                $languageLabelString = new LanguageLabelString();
                $languageLabelString->setLabelId($this->testCases['Label'][$key]['label_id']);
                $languageLabelString->setLanguageId($this->testCases['Language']['data1']['language_id']);
                $languageLabelString->setLanguageLabelString($testCase['language_label_string']);
                $languageLabelString->setLanguageLabelStringStatus($testCase['language_label_string_status']);

                $this->localizationDao->addLangStr($languageLabelString);
                //Label Id + Language Id + Language String must be uniq.
                //This should not get inserted
                $this->assertTrue(false);
            } catch (Exception $ex) {
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
        foreach ($this->testCases['LanguageLabelString'] as $key => $testCase) {
            $languageLabelString = new LanguageLabelString();
            $languageLabelString->setLanguageLabelStringId($testCase['language_label_string_id']);
            $languageLabelString->setLabelId($this->testCases['Label'][$key]['label_id']);
            $languageLabelString->setLanguageId($this->testCases['Language']['data1']['language_id']);
            $languageLabelString->setLanguageLabelString($testCase['language_label_string']);
            $languageLabelString->setLanguageLabelStringStatus($testCase['language_label_string_status']);

            $languageLabelStringUpdated = $this->localizationDao->updateLangStr($languageLabelString);
            $this->assertTrue(($languageLabelStringUpdated === true) || ($languageLabelStringUpdated === false));
        }
    }

    /**
     * Test Get language string list by source and target Language Id
     *
     */
    public function testGetLangStrBySrcAndTargetIds() {
        foreach ($this->testCases['LanguageLabelString'] as $key => $testCase) {
            $result = $this->localizationDao->
                            getLangStrBySrcAndTargetIds($testCase['source_language_id'], $testCase['target_language_id']);
            $this->assertTrue(($result instanceof Doctrine_Collection) || ($result->count() == false));
        }
    }
}
