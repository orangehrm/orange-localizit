<?php
class localizationComponents extends sfComponents {

    private $localizationService ;

    /**
     * Get Localization Service
     */
    public function getLocalizeService() {
        $this->localizationService	=	new LocalizationService();
        $this->localizationService->setLocalizationDao( new LocalizationDao);
        return $this->localizationService;
    }

    public function executeLanguageList(sfWebRequest $request) {
        
        $localizationService=$this->getLocalizeService();

        $this->languageList=$localizationService->getLanguageList();
        $this->sourceLanguageId=$this->getUser()->getAttribute('user_language_id');

    }
}