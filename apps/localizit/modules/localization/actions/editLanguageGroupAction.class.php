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

    public function execute($request) {
        $this->langGroup = $this->localizationService->getLanguageGroupById($request->getParameter('id'));
        $this->id = $request->getParameter('id');

        $this->editLangGroupForm = new LanguageGroupForm($this->langGroup);
    }

}

