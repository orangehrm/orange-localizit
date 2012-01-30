<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of addLanguageGroupAction
 *
 * @author waruni
 */
class addLanguageGroupAction extends sfAction {

    private $localizationService;

    /**
     * Get Localization Service
     */
    public function getLocalizeService() {
        $this->localizationService = new LocalizationService();
        $this->localizationService->setLocalizationDao(new LocalizationDao);
        return $this->localizationService;
    }

    public function preExecute() {
        if(!$this->getUser()->isAuthenticated()) {
            $this->redirect('@loginpage');
        }
    }
    
    /**
     * Adding Language Group
     * @param <type> $request 
     */
    public function execute($request) {
        $localizationService = $this->getLocalizeService();

        $this->addLanguageGroupForm = new LanguageGroupForm();

        if ($request->isMethod(sfRequest::POST)) {
            $this->addLanguageGroupForm->bind($request->getParameter($this->addLanguageGroupForm->getName()));

            if ($this->addLanguageGroupForm->isValid()) {

                $languageGroup = new Group();
                $languageGroup->setName($this->addLanguageGroupForm->getValue('group_name'));
                $localizationService->saveGroup($languageGroup);
                $this->redirect('@language_group_list');
            }
        }
    }

}
