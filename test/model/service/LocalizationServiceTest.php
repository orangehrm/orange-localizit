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
 * localization Service Test class
 *
 * @author ruwan
 */
require_once 'PHPUnit/Framework.php';

class LocalizationServiceTest extends PHPUnit_Framework_TestCase {

    private $testCases;
    private $locaizationService;
    private $localizationDao;

    /**
     * PHPUnit setup function
     */
    public function setup() {
        $this->locaizationService = new LocalizationService();
        $this->testCases = sfYaml::load(sfConfig::get('sf_test_dir') . '/fixtures/localization/localization_test.yml');
    }

    /**
     * Test Add label function
     *
     */
    public function testAddLabel() {

        foreach ($this->testCases['Label'] as $key => $testCase) {
            $label = new Label();
            $label->setLabelName($testCase['label_name']);
            $label->setLabelComment($testCase['label_comment']);
            $label->setLabelStatus($testCase['label_status']);

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('addLabel')
                    ->will($this->returnValue($label));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->addLabel($testCase['label_name'], $testCase['label_comment']);
            $this->assertTrue($result instanceof Label);
            $this->assertEquals($label, $result);
        }
    }

    /**
     * Test Add label function
     *
     */
    public function testAddLabelEx() {

        try {
            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('addLabel')
                    ->will($this->throwException(New DaoException()));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->addLabel('lable_name', 'label_comment');
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test get label by name function
     *
     */
    public function testGetLabelByName() {

        foreach ($this->testCases['Label'] as $key => $testCase) {
            $label = new Label();
            $label->setLabelName($testCase['label_name']);
            $label->setLabelComment($testCase['label_comment']);
            $label->setLabelStatus($testCase['label_status']);

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('getLabelByName')
                    ->will($this->returnValue($label));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->getLabelByName($testCase['label_name']);
            $this->assertTrue($result instanceof Label);
            $this->assertEquals($label, $result);
        }
    }

    /**
     * Test get label by invalid name function
     *
     */
    public function testGetLabelByInvalidName() {

        foreach ($this->testCases['Label'] as $key => $testCase) {
            $label = new Label();
            $label->setLabelName($testCase['label_name']);
            $label->setLabelComment($testCase['label_comment']);
            $label->setLabelStatus($testCase['label_status']);

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('getLabelByName')
                    ->will($this->returnValue(NULL));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->getLabelByName($testCase['label_name']);
            $this->assertNull($result);
        }
    }

    /**
     * Test get label by name function
     *
     */
    public function testGetLabelByNameEx() {

        try {
            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('getLabelByName')
                    ->will($this->throwException(New DaoException()));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->getLabelByName('lable_name');
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test update label function
     *
     */
    public function testUpdateLabel() {

        foreach ($this->testCases['Label'] as $key => $testCase) {
            $label = new Label();
            $label->setLabelId($testCase['label_id']);
            $label->setLabelName($testCase['label_name']);
            $label->setLabelComment($testCase['label_comment']);
            $label->setLabelStatus($testCase['label_status']);

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('updateLabel')
                    ->will($this->returnValue(TRUE));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->updateLabel($label);
            $this->assertTrue($result);
        }
    }

    /**
     * Test update label function
     *
     */
    public function testUpdateLabelEx() {

        try {
            $label = new Label();

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('updateLabel')
                    ->will($this->throwException(New DaoException()));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->updateLabel($label);
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Get Language List
     */
    public function testGetLanguageListl() {
        $this->localizationDao = $this->getMock('LocalizationDao');
        $this->localizationDao->expects($this->once())
                ->method('getLanguageList')
                ->will($this->returnValue(Doctrine_Collection));

        $this->locaizationService->setLocalizationDao($this->localizationDao);

        $result = $this->locaizationService->getLanguageList();
        $this->assertTrue(true);
    }

    /**
     * Test Get Language List
     *
     */
    public function testGetLanguageListlEx() {

        try {

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('getLanguageList')
                    ->will($this->throwException(New DaoException()));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->getLanguageList();
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Get Language by code
     *
     */
    public function testGetLanguageByCode() {

        foreach ($this->testCases['Language'] as $key => $testCase) {
            $lang = new Language();
            $lang->setLanguageId($testCase['language_id']);
            $lang->setLanguageCode($testCase['language_code']);
            $lang->setLanguageName($testCase['language_name']);
            $lang->setLanguageStatus($testCase['language_status']);

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('getLanguageByCode')
                    ->will($this->returnValue($lang));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->getLanguageByCode($testCase['language_code']);
            $this->assertTrue($result instanceof Language);
            $this->assertEquals($lang, $result);
        }
    }

    /**
     * Test Get Language by code
     *
     */
    public function testGetLanguageByCodeEx() {

        try {

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('getLanguageByCode')
                    ->will($this->throwException(New DaoException()));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->getLanguageByCode('lang_code');
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Get Language by invalid code
     *
     */
    public function testGetLanguageByInvalidCode() {

        $this->localizationDao = $this->getMock('LocalizationDao');
        $this->localizationDao->expects($this->once())
                ->method('getLanguageByCode')
                ->will($this->returnValue(NULL));

        $this->locaizationService->setLocalizationDao($this->localizationDao);

        $result = $this->locaizationService->getLanguageByCode('language_code');
        $this->assertNull($result);
    }

    /**
     * Test Get Language by id
     *
     */
    public function testGetLanguageById() {

        foreach ($this->testCases['Language'] as $key => $testCase) {
            $lang = new Language();
            $lang->setLanguageId($testCase['language_id']);
            $lang->setLanguageCode($testCase['language_code']);
            $lang->setLanguageName($testCase['language_name']);
            $lang->setLanguageStatus($testCase['language_status']);

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('getLanguageById')
                    ->will($this->returnValue($lang));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->getLanguageById($testCase['language_id']);
            $this->assertTrue($result instanceof Language);
            $this->assertEquals($lang, $result);
        }
    }

    /**
     * Test Get Language by invalid id
     *
     */
    public function testGetLanguageByInvalidId() {

        $this->localizationDao = $this->getMock('LocalizationDao');
        $this->localizationDao->expects($this->once())
                ->method('getLanguageById')
                ->will($this->returnValue(NULL));

        $this->locaizationService->setLocalizationDao($this->localizationDao);

        $result = $this->locaizationService->getLanguageById('language_id');
        $this->assertNull($result);
    }

    /**
     * Test Get Language by id
     *
     */
    public function testGetLanguageByIdEx() {

        try {

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('getLanguageById')
                    ->will($this->throwException(New DaoException()));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->getLanguageById('lang_id');
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Get Label And Lang Data Set
     *
     */
    public function testGetLabelAndLangDataSetDif() {

        $label_list = array();
        $lang_label_list = array();

        foreach ($this->testCases['Label'] as $key => $testCase) {
            $label = new Label();
            $label->setLabelId($testCase['label_id']);
            $label->setLabelName($testCase['label_name']);
            $label->setLabelComment($testCase['label_comment']);
            $label->setLabelStatus($testCase['label_status']);

            array_push($label_list, $label);
        }

        foreach ($this->testCases['LanguageLabelString'] as $key => $testCase) {
            $lang_str = new LanguageLabelString();
            $lang_str->setLanguageLabelStringId($testCase['language_label_string_id']);
            $lang_str->setLabelId($testCase['label_id']);
            $lang_str->setLanguageId($testCase['language_id']);
            $lang_str->setLanguageLabelString($testCase['language_label_string']);
            $lang_str->setLanguageLabelStringStatus($testCase['language_label_string_status']);

            array_push($lang_label_list, $lang_str);
        }

        $this->localizationDao = $this->getMock('LocalizationDao');
        $this->localizationDao->expects($this->once())
                ->method('getLabelList')
                ->will($this->returnValue($label_list));

        $this->localizationDao->expects($this->once())
                ->method('getLangStrBySrcAndTargetIds')
                ->will($this->returnValue($lang_label_list));

        $this->locaizationService->setLocalizationDao($this->localizationDao);

        $result = $this->locaizationService->getLabelAndLangDataSet(1, 1);
        $this->assertTrue(true);
    }

    /**
     * Test Get Label And Lang Data Set
     *
     */
    public function testGetLabelAndLangDataSet() {

        $label_list = array();
        $lang_label_list = array();

        foreach ($this->testCases['Label'] as $key => $testCase) {
            $label = new Label();
            $label->setLabelId($testCase['label_id']);
            $label->setLabelName($testCase['label_name']);
            $label->setLabelComment($testCase['label_comment']);
            $label->setLabelStatus($testCase['label_status']);

            array_push($label_list, $label);
        }

        foreach ($this->testCases['LanguageLabelString'] as $key => $testCase) {
            $lang_str = new LanguageLabelString();
            $lang_str->setLanguageLabelStringId($testCase['language_label_string_id']);
            $lang_str->setLabelId($testCase['label_id']);
            $lang_str->setLanguageId($testCase['language_id']);
            $lang_str->setLanguageLabelString($testCase['language_label_string']);
            $lang_str->setLanguageLabelStringStatus($testCase['language_label_string_status']);

            array_push($lang_label_list, $lang_str);
        }

        $this->localizationDao = $this->getMock('LocalizationDao');
        $this->localizationDao->expects($this->once())
                ->method('getLabelList')
                ->will($this->returnValue($label_list));

        $this->localizationDao->expects($this->once())
                ->method('getLangStrBySrcAndTargetIds')
                ->will($this->returnValue($lang_label_list));

        $this->locaizationService->setLocalizationDao($this->localizationDao);

        $result = $this->locaizationService->getLabelAndLangDataSet(2, 1);
        $this->assertTrue(true);
    }

    /**
     * Test Get Label And Lang Data Set
     *
     */
    public function testGetLabelAndLangDataSetEx() {

        try {

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('getLangStrBySrcAndTargetIds')
                    ->will($this->throwException(New DaoException()));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->getLabelAndLangDataSet('s_lang_id', 't_lang_id');
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Add Language String
     *
     */
    public function testAddLangStr() {

        foreach ($this->testCases['LanguageLabelString'] as $key => $testCase) {
            $lang_str = new LanguageLabelString();
            $lang_str->setLanguageLabelStringId($testCase['language_label_string_id']);
            $lang_str->setLabelId($testCase['label_id']);
            $lang_str->setLanguageId($testCase['language_id']);
            $lang_str->setLanguageLabelString($testCase['language_label_string']);
            $lang_str->setLanguageLabelStringStatus($testCase['language_label_string_status']);

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('addLangStr')
                    ->will($this->returnValue($lang_str));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->addLangStr($lang_str);
            $this->assertTrue($result instanceof LanguageLabelString);
            $this->assertEquals($lang_str, $result);
        }
    }

    /**
     * Test Add Language String
     *
     */
    public function testAddLangStrEx() {

        try {

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('addLangStr')
                    ->will($this->throwException(New DaoException()));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->addLangStr(new LanguageLabelString());
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test update Language String function
     *
     */
    public function testUpdateLangStr() {

        foreach ($this->testCases['LanguageLabelString'] as $key => $testCase) {
            $langStr = new LanguageLabelString();
            $langStr->setLanguageLabelStringId($testCase['language_label_string_id']);
            $langStr->setLabelId($testCase['label_id']);
            $langStr->setLanguageId($testCase['language_id']);
            $langStr->setLanguageLabelString($testCase['language_label_string']);
            $langStr->setLanguageLabelStringStatus($testCase['language_label_string_status']);

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('updateLangStr')
                    ->will($this->returnValue(TRUE));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->updateLangStr($langStr);
            $this->assertTrue($result);
        }
    }

    /**
     * Test update Language String function
     *
     */
    public function testUpdateLangStrEx() {

        try {

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('updateLangStr')
                    ->will($this->throwException(New DaoException()));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->updateLangStr(new LanguageLabelString());
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Generate Dictionary method
     *
     */
    public function testGenerateDictionary() {

        $lan = new Language();
        $lan->setLanguageCode('en_US');
        $lan->setLanguageId(1);
        $lan->setLanguageName('English');
        $lan->setLanguageStatus('');

        $labelList = array();
        $langLabelList = array();

        foreach ($this->testCases['Label'] as $key => $testCase) {
            $label = new Label();
            $label->setLabelId($testCase['label_id']);
            $label->setLabelName($testCase['label_name']);
            $label->setLabelComment($testCase['label_comment']);
            $label->setLabelStatus($testCase['label_status']);

            array_push($labelList, $label);
        }

        foreach ($this->testCases['LanguageLabelString'] as $key => $testCase) {
            $langStr = new LanguageLabelString();
            $langStr->setLanguageLabelStringId($testCase['language_label_string_id']);
            $langStr->setLabelId($testCase['label_id']);
            $langStr->setLanguageId($testCase['language_id']);
            $langStr->setLanguageLabelString($testCase['language_label_string']);
            $langStr->setLanguageLabelStringStatus($testCase['language_label_string_status']);

            array_push($langLabelList, $langStr);
        }

        $this->localizationDao = $this->getMock('LocalizationDao');

        $this->localizationDao->expects($this->once())
                ->method('getLanguageById')
                ->will($this->returnValue($lan));

        $this->localizationDao->expects($this->once())
                ->method('getLabelList')
                ->will($this->returnValue($labelList));

        $this->localizationDao->expects($this->once())
                ->method('getLangStrBySrcAndTargetIds')
                ->will($this->returnValue($langLabelList));

        $this->locaizationService->setLocalizationDao($this->localizationDao);

        $result = $this->locaizationService->generateDictionary('1', '2', 'en_US');
        $this->assertTrue($result);
        $this->assertFileExists(sfConfig::get('sf_web_dir') . "/language_files/messages.en_US.xml");
    }

    /**
     * Test Generate Dictionary method
     *
     */
    public function testGenerateDictionaryEx() {

        try {

            $this->localizationDao = $this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('getLanguageById')
                    ->will($this->throwException(New DaoException()));

            $this->locaizationService->setLocalizationDao($this->localizationDao);

            $result = $this->locaizationService->generateDictionary('1', '2', 'en_US');
        } catch (Exception $ex) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }

    /**
     * Test Download Dictionary method
     *
     */
    public function testDownloadDictionary() {

        $result = $this->locaizationService->downloadDictionary(sfConfig::get('sf_web_dir') . "/language_files/messages.en_US.xml");
        $this->assertTrue($result);
        $this->assertFileExists(sfConfig::get('sf_web_dir') . "/language_files/messages.en_US.xml");

        //deletes the test file
        unlink(sfConfig::get('sf_web_dir') . "/language_files/messages.en_US.xml");
    }

    /**
     * Test Download Dictionary method -- file not exists
     *
     */
    public function testDownloadInvalidDictionary() {
        try {
            $result = $this->locaizationService->downloadDictionary(sfConfig::get('sf_web_dir') . "/language_files/messages.en_US.xml");
            $this->assertTrue($result);
        } catch (Exception $ex) {
            //has to fire a service exception
            return;
        }
        $this->fail('An expected exception has not been raised.');
    }
}