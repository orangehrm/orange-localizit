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
 * localization Service Test class
 *
 * @author ruwan
 */
require_once 'PHPUnit/Framework.php';

class LocalizationServiceTest  extends  PHPUnit_Framework_TestCase {

    private $testCases;
    private $locaizationService;
    private $localizationDao	;

    /**
     * PHPUnit setup function
     */
    public function setup() {
        $this->locaizationService	=	new LocalizationService();
        $this->testCases 	= sfYaml::load(sfConfig::get('sf_test_dir') . '/fixtures/localization/localization.yml');

    }

    /**
     * Test Add label function
     *
     */
    public function testAddLabel() {

        foreach ($this->testCases['Label'] as $key=>$testCase) {
            $label	=	new Label();
            $label->setLabelName( $testCase['label_name']);
            $label->setLabelComment( $testCase['label_comment']);
            $label->setLabelStatus( $testCase['label_status']);

            $this->localizationDao		=	$this->getMock('LocalizationDao');
            $this->localizationDao->expects($this->once())
                    ->method('addLabel')
                    ->will($this->returnValue($label));
            ;

            $this->locaizationService->setLocalizationDao( $this->localizationDao );

            $result 	=	$this->locaizationService->addLabel($testCase['label_name'],$testCase['label_comment'] );
            $this->assertEquals( $label , $result );

        }

    }

    /**
     * Test Get Language List
     *
     */
    public function testGetLanguageListl() {
        $this->localizationDao		=	$this->getMock('LocalizationDao');
        $this->localizationDao->expects($this->once())
                ->method('getLanguageList')
                ->will($this->returnValue(Doctrine_Collection));

        $this->locaizationService->setLocalizationDao( $this->localizationDao );

        $result 	=	$this->locaizationService->getLanguageList();
        $this->assertTrue(true);
    }
}