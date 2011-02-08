<?php
/**
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
 */

/**
 * Actions class for localization module
 */
class localizationActions extends sfActions {

    private $localizationService ;

    /**
     * Get Localization Service
     */
    public function getLocalizeService() {
        $this->localizationService	=	new LocalizationService();
        $this->localizationService->setLocalizationDao( new LocalizationDao);
        return $this->localizationService;
    }

    /**
     * This method is executed before each action
     */
    public function preExecute() {

        $userObject=$this->getUser();
        if(!$userObject->getAttribute('user_language_id')) {
            $localizationService=$this->getLocalizeService();
            $userObject->setAttribute('user_language_id',$localizationService->getLanguageByCode($userObject->getCulture())->getLanguageId());
            unset($localizationDao);
        }
    }
    public function executeIndex(sfWebRequest $request) {

        if($request->isMethod(sfRequest::POST)) {
            $labelIdArray=$request->getParameter('label_id');
            $labelTextArray=$request->getParameter('label_name');

            $sourceLanguageStringArray=$request->getParameter('source_language_string');
            $sourceLanguageStringIdArray=$request->getParameter('source_language_string_id');

            $targetLanguageStringArray=$request->getParameter('target_language_string');
            $targetLanguageStringIdArray=$request->getParameter('target_language_string_id');

            $targetLanguageId=$request->getParameter('target_language_selected_id');

            $labelCommentArray=$request->getParameter('label_comment');

            $loopCounter=count($labelIdArray);
            $localizationService=$this->getLocalizeService();

            for ($index = 0; $index < $loopCounter; $index++) {

                $label=new Label();
                $label->setLabelId($labelIdArray[$index]);
                $label->setLabelName($labelTextArray[$index]);
                $label->setLabelComment($labelCommentArray[$index]);
                $label->setLabelStatus(sfConfig::get('app_status_enabled'));
                $localizationService->updateLabel($label);

                $sourceLls=new LanguageLabelString();
                $sourceLls->setLanguageLabelString($sourceLanguageStringArray[$index]);
                $sourceLls->setLabelId($labelIdArray[$index]);
                $sourceLls->setLanguageId($this->getUser()->getAttribute('user_language_id'));
                $sourceLls->setLanguageLabelStringStatus(sfConfig::get('app_status_enabled'));
                if($sourceLanguageStringIdArray[$index]) {
                    $sourceLls->setLanguageLabelStringId($sourceLanguageStringIdArray[$index]);
                    $localizationService->updateLangStr($sourceLls);
                }else {
                    $localizationService->addLangStr($sourceLls);
                }

                $targetLls=new LanguageLabelString();
                $targetLls->setLabelId($labelIdArray[$index]);
                $targetLls->setLanguageId($targetLanguageId);
                $targetLls->setLanguageLabelStringStatus(sfConfig::get('app_status_enabled'));
                $targetLls->setLanguageLabelString($targetLanguageStringArray[$index]);
                if($targetLanguageStringIdArray[$index]) {
                    $targetLls->setLanguageLabelStringId($targetLanguageStringIdArray[$index]);
                    $localizationService->updateLangStr($targetLls);
                }else {
                    $localizationService->addLangStr($targetLls);
                }

            }
        }
        $localizationService=$this->getLocalizeService();
        $this->addLabelForm =  new LabelForm($localizationService);
        $this->sourceLanguageLabel=$this->getUser()->getCulture();
        $this->showAddLabel=false;

    }

    public function executeAddLabel(sfWebRequest $request) {
        $localizationService=$this->getLocalizeService();
        $this->addLabelForm =  new LabelForm($localizationService);
        if($request->isMethod(sfRequest::POST)) {
            $this->addLabelForm->bind($request->getParameter('add_label'));

            if ($this->addLabelForm->isValid()) {
                if($this->addLabelForm->saveToDb()){
                    $this->redirect('@homepage');
                }
            }
        }
        $this->showAddLabel=true;
        $this->sourceLanguageLabel=$this->getUser()->getCulture();
        $this->setTemplate('index');
    }

    public function executeLanguageLabelDataSet(sfWebRequest $request) {
        $localizationService=$this->getLocalizeService();

        $sourceLanguageId=$this->getUser()->getAttribute('user_language_id');
        $targetLanguageId=$request->getParameter('targetLanguageId');

        $this->sourceLanguageLabel=$this->getUser()->getCulture();
        $this->targetLanguageLabel=$localizationService->getLanguageById($targetLanguageId)->getLanguageCode();
        $this->languageLabelDataSet=$localizationService->getLabelAndLangDataSet($sourceLanguageId,$targetLanguageId);
    }

    public function executeEditLanguageLabelData(sfWebRequest $request) {
        $localizationService=$this->getLocalizeService();

        $this->sourceLanguageId=$this->getUser()->getAttribute('user_language_id');
        $this->targetLanguageId=$request->getParameter('targetLanguageId');

        $this->sourceLanguageLabel=$this->getUser()->getCulture();
        $this->targetLanguageLabel=$localizationService->getLanguageById($this->targetLanguageId)->getLanguageCode();
        $this->languageLabelDataSet=$localizationService->getLabelAndLangDataSet($this->sourceLanguageId,$this->targetLanguageId);
    }

}
