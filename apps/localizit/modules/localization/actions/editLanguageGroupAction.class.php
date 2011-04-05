<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of editLanguageGroupAction
 *
 * @author waruni
 */
class editLanguageGroupAction extends sfAction {

    private $localizationService;

    /**
     * Get Localization Service
     */
    public function getLocalizeService() {
        $this->localizationService = new LocalizationService();
        $this->localizationService->setLocalizationDao(new LocalizationDao);
        return $this->localizationService;
    }

    /**
     * Edit Language Group .
     * @param <type> $request
     */
    public function execute($request) {
        $localizationService = $this->getLocalizeService();
        $this->editLangGroupForm = new LanguageGroupForm();
        $this->langGroup = $localizationService->getLanguageGroupById($request->getParameter('id'));
        $this->id = $request->getParameter('id');

        if ($request->isMethod(sfRequest::POST)) {
            $this->editLangGroupForm->bind($request->getParameter($this->editLangGroupForm->getName()));

            if ($this->editLangGroupForm->isValid()) {
                $this->langGroup->setGroupName($this->editLangGroupForm->getValue('group_name'));
                if($localizationService->updateLanguageGroup($this->langGroup)) {
                     $this->redirect('@language_group_list');
                }
            }
        }
    }

}

