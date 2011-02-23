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
     * Get label
     * @param $labelName
     * @throws ServiceException
     * @return Label
     */
    public function getLabelByName($labelName) {
        $localizationDao=$this->getLocalizationDao();
        try {
            return $localizationDao->getLabelByName($labelName);
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(),$exc->getCode());
        }
    }

    /**
     * Update Label
     * @param Label $label
     * @returns boolean
     * @throws DaoException
     */
    public function updateLabel(Label $label) {
        $localizationDao=$this->getLocalizationDao();
        try {
            $localizationDao->updateLabel($label);
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

    /**
     * Get Language By Id
     * @param int $languageId
     * @return Label
     */
    public function getLanguageById($languageId) {
        $localizationDao=$this->getLocalizationDao();
        try {
            return $localizationDao->getLanguageById($languageId);
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(),$exc->getCode());
        }

    }

    /**
     * Get Label and Language set by source and targetLanguage
     * @param $sourceLanguageId,$targetLanguageId
     * @param string $languageCode
     * @return array
     */
    public function getLabelAndLangDataSet($sourceLanguageId,$targetLanguageId) {

        $localizationDao=$this->getLocalizationDao();
        $dataSet=array();
        try {
            $labelList=$localizationDao->getLabelList();
            $languageLabelSet=$localizationDao->getLangStrBySrcAndTargetIds($sourceLanguageId,$targetLanguageId);

            if($labelList) {

                foreach($labelList as $label) {



                    $dataRow[$label->getLabelId()]['label_id']=$label->getLabelId();
                    $dataRow[$label->getLabelId()]['label_name']=$label->getLabelName();

                    foreach($languageLabelSet as $languageLabel) {

                        if($languageLabel->getLanguageLabelStringStatus()==sfConfig::get('app_status_enabled')) {

                            if($label->getLabelId()==$languageLabel->getLabelId()) {

                                if($sourceLanguageId==$languageLabel->getLanguageId()) {

                                    $dataRow[$label->getLabelId()]['source_language_label_string_id']=$languageLabel->getLanguageLabelStringId();
                                    $dataRow[$label->getLabelId()]['source_language_id']= $languageLabel->getLanguageId();
                                    $dataRow[$label->getLabelId()]['source_language_label']= $languageLabel->getLanguageLabelString();
                                    $dataRow[$label->getLabelId()]['comment']=$label->getLabelComment();

                                }elseif($targetLanguageId==$languageLabel->getLanguageId()) {
                                    $dataRow[$label->getLabelId()]['target_language_label_string_id']=$languageLabel->getLanguageLabelStringId();
                                    $dataRow[$label->getLabelId()]['target_language_id']=$languageLabel->getLanguageId();
                                    $dataRow[$label->getLabelId()]['target_language_label']=$languageLabel->getLanguageLabelString();

                                }
                            }
                        }

                    }
                    $dataSet[$label->getLabelId()]=$dataRow;
                }

            }
            return $dataSet;
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(),$exc->getCode());
        }
    }

    /**
     * Create Language String
     * @param LanguageLabelString $lls
     * @returns LanguageLabelString
     * @throws ServiceException
     */
    public function addLangStr(LanguageLabelString $lls) {
        $localizationDao=$this->getLocalizationDao();
        try {
            return $localizationDao->addLangStr($lls);
        } catch(Exception $exc) {
            throw new ServiceException($exc->getMessage(),$exc->getCode());
        }
    }

    /**
     * Update Language String
     * @param LanguageLabelString $lls
     * @returns boolean
     * @throws ServiceException
     */
    public function updateLangStr(LanguageLabelString $lls) {
        $localizationDao=$this->getLocalizationDao();
        try {
            return $localizationDao->updateLangStr($lls);
        } catch(Exception $exc) {
            throw new ServiceException($exc->getMessage(),$exc->getCode());
        }
    }

}