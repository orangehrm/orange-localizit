<?php

/**
 * Description of viewTranslateTextAction
 *
 */
class viewTranslateTextAction extends sfAction {
    
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
     * This method is executed before each action
     */
    public function preExecute() {
        if(!$this->getUser()->isAuthenticated()) {
            $this->redirect('@loginpage');
        }
        $this->targetLanguageId = null;
        $this->languageGroupId = null;
        $this->sourceList = null;
        $userObject = $this->getUser();
        $this->role = sfContext::getInstance()->getUser()->getUserRole();
        if (!$userObject->getAttribute('user_language_id')) {
            $localizationService = $this->getLocalizeService();
            $userObject->setAttribute('user_language_id', $localizationService->getLanguageByCode($userObject->getCulture())->getId());
            unset($localizationDao);
        }
    }
    public function execute($request) {
        $this->pageNumber = $pageNumber = 2;
        $this->pageLimit = $pageLimit = sfConfig::get('app_items_per_page');
        
        $userLanguageIds = $this->role->getAllowedLanguageList();
        
        $this->languageIds = $this->getLocalizeService()->getUserLanguageList($userLanguageIds);
        
        if ($request->isMethod(sfRequest::POST)) {
            $this->targetLanguageId = $request->getParameter('languageList');
            $form = $request->getParameter('add_label');
            $this->languageGroupId = $form['language_group_id'];
            if(($this->targetLanguageId == 0) || ($this->languageGroupId == 0)) {
                $this->getUser()->setFlash('errorMessage', "Select Valid Target Language and Language Group", false);
            } else {
                
                $this->listValues = $this->getLocalizeService()->getTranslateListAsArray($this->targetLanguageId, $this->languageGroupId, $pageNumber);
                
                if(count($this->listValues) == 0) {
                    $this->getUser()->setFlash('errorMessage', "No Records to Display", false);
                }
            }
        }
        
        $this->redirectByAutoSubmit = $request->getParameter('redirectByAutoSubmit');
        
        $localizationService = $this->getLocalizeService();
        $this->addLabelForm = new LabelForm($localizationService);
        $this->sourceLanguage= $localizationService->getLanguageByCode($this->getUser()->getCulture());
        $this->showAddLabel = false;
    }
    
}