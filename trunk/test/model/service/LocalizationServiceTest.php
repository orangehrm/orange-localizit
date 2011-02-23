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
     * Test Get Language List
     *
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
     * Test Generate Dictionary method
     *
     */
    public function testGenerateDictionary() {

        $lan = new Language();
        $lan->setLanguageCode('en_US');
        $lan->setLanguageId(1);
        $lan->setLanguageName('English');
        $lan->setLanguageStatus('');

        $this->localizationDao = $this->getMock('LocalizationDao');

        $this->localizationDao->expects($this->once())
                ->method('getLanguageById')
                ->will($this->returnValue($lan));

        $this->locaizationService->setLocalizationDao($this->localizationDao);

        $result = $this->locaizationService->generateDictionary('1', '2', 'en_US');
        $this->assertTrue($result);
        $this->assertFileExists(sfConfig::get('sf_web_dir') . "/language_files/messages.en_US.xml");
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
            $this->assertTrue(TRUE);
        }
    }
}