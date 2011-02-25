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
     * Test Save Label
     *
     */
    public function testAddLabelEx() {
        try {
            $label = new Label();
            $label->setLabelId(1);
            $label->setLabelName('test_1');
            $label->setLabelComment('test_1');
            $label->setLabelStatus('test_1');

            $labelCreated = $this->localizationDao->addLabel($label);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Update Label
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
     * Test Update Label
     *
     */
    public function testUpdateLabelEx() {

        try {
            $label = new Label();
            $label->setLabelId(1);
            $label->setLabelName(new Label());
            $label->setLabelComment(NULL);
            $label->setLabelStatus(NULL);

            $labelUpdated = $this->localizationDao->updateLabel($label);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Get Data List (lables)
     *
     */
    public function testGetLabelList() {
        $result = $this->localizationDao->getDataList('Label');
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
     * Test Get Label By Id
     *
     */
    public function testGetLabelByIdEx() {

        try {
            $illegal = array('%', '-', '.');
            $labelUpdated = $this->localizationDao->getLabelById($illegal);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
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
     * Test Get Label By Name
     *
     */
    public function testGetLabelByNameEx() {

        try {
            $illegal = array('%', '-', '.');
            $labelUpdated = $this->localizationDao->getLabelByName($illegal);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
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
     * Test Get Data List (language)
     *
     */
    public function testGetLanguagelList() {
        $result = $this->localizationDao->getDataList('Language');
        $this->assertTrue(($result instanceof Doctrine_Collection));
    }


    /**
     * Test Get Language List
     *
     */
    public function testGetDataListEx() {

        try {
            $illegal = array('%', '-', '.');
            $labelUpdated = $this->localizationDao->getDataList($illegal);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
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
     * Test Get Language By Id
     *
     */
    public function testGetLanguagelByIdEx() {

        try {
            $illegal = array('%', '-', '.');
            $labelUpdated = $this->localizationDao->getLanguageById($illegal);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
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
     * Test Get Language by code
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
     * Test Get Language by code
     *
     */
    public function testGetLanguagelByCodeEx() {

        try {
            $illegal = array('%', '-', '.');
            $labelUpdated = $this->localizationDao->getLanguageByCode($illegal);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
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
     * Test Add language string
     *
     */
    public function testAddLanStrEx() {

        try {
            $languageLabelString = new LanguageLabelString();
            $languageLabelString->setLanguageLabelStringId(1);
            $languageLabelString->setLabelId(3);
            $languageLabelString->setLanguageId(3);
            $languageLabelString->setLanguageLabelString('language_label_string');
            $languageLabelString->setLanguageLabelStringStatus('language_label_string_status');

            $languageLabelStringCreated = $this->localizationDao->addLangStr($languageLabelString);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test update language string
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
     * Test update language string
     *
     */
    public function testUpdateLanStrEx() {

        try {
            $languageLabelString = new LanguageLabelString(NULL);
            $languageLabelString->setLanguageLabelStringId(NULL);
            $languageLabelString->setLabelId(NULL);
            $languageLabelString->setLanguageId(NULL);
            $languageLabelString->setLanguageLabelString(NULL);
            $languageLabelString->setLanguageLabelStringStatus(NULL);

            $languageLabelStringCreated = $this->localizationDao->updateLangStr($languageLabelString);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
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

     /**
     * Test Get language string list by source and target Language Id
     *
     */
    public function testGetLangStrBySrcAndTargetIdsEx() {

        try {
            $illegal = array('%', '-', '.');
            $labelUpdated = $this->localizationDao->getLangStrBySrcAndTargetIds($illegal,$illegal);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }
}
