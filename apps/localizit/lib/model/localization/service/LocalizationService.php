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
 * Description of DefineKpiService
 *
 * @author Samantha Jayasinghe
 */
class LocalizationService extends BaseService {

    private $localizationDao ;


    public function getLocalizationDao() {
        return $this->localizationDao;
    }

    public function setLocalizationDao( LocalizationDao $locaizationDao) {
        $this->localizationDao	=	$locaizationDao ;
    }

    /**
     * Add new label
     * @param $labelName,$labelComment
     * @throws ServiceException
     * @return Label
     */
    public function addLabel($labelName,$labelComment) {

        $localizationDao=$this->getLocalizationDao();

        if($localizationDao->getLabelByName($labelName) instanceof Label) {
            $error=sfConfig::get('app_error_label_alreay_exists');
            throw new ServiceException($error['messaeg'],$error['code']);
        }

        try {
            $label=new Label();
            $label->setLabelName($labelName);
            $label->setLabelComment($labelComment);
            $label->setLabelStatus(sfConfig::get('app_status_enabled'));

            return $localizationDao->addLabel($label);

        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(),$exc->getCode());
        }

    }

    /**
     * Get Language List
     * @returns Language Collection
     * @return Label
     */
    public function getLanguageList() {
        $localizationDao=$this->getLocalizationDao();
        try {
            return $localizationDao->getLanguageList();
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(),$exc->getCode());
        }

    }

    /**
     * Get Language By Code
     * @param string $languageCode
     * @return Label
     */
    public function getLanguageByCode($languageCode) {
        $localizationDao=$this->getLocalizationDao();
        try {
            return $localizationDao->getLanguageByCode($languageCode);
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(),$exc->getCode());
        }

    }
}