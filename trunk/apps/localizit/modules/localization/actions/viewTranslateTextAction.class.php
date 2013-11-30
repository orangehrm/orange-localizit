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
    
    public function setPagination($pageNo, $limit, $totalRecordCount) {
        
        $pager = new SimplePager($this->className, $limit);
        $pager->setPage($pageNo);
        $pager->setNumResults($totalRecordCount);
        $pager->init();
        
        $this->pager = $pager;
    }
    
    public function execute($request) {
        $userLanguageIds = $this->role->getAllowedLanguageList();
        $this->languageIds = $this->getLocalizeService()->getUserLanguageList($userLanguageIds);
        
        $this->pageNo = $request->getParameter('pageNo', 1);
        $limit = sfConfig::get('app_items_per_page');
        $this->offset = ($this->pageNo >= 1) ? (($this->pageNo - 1) * $limit) : 0;
        
        if ($request->isMethod(sfRequest::POST)) {
            $this->targetLanguageId = $request->getParameter('languageList');
            $form = $request->getParameter('add_label');
            $this->languageGroupId = $form['language_group_id'];
            if(($this->targetLanguageId == 0) || ($this->languageGroupId == 0)) {
                $this->getUser()->setFlash('errorMessage', "Select Valid Target Language and Language Group", false);
            } else {
                $sourceAndTargetData = $this->getLocalizeService()->getSourceAndTargetListAsArray($this->targetLanguageId, $this->languageGroupId, $this->offset, $limit);
                $this->listValues = $sourceAndTargetData['data'];
                $this->listTotalCount = $sourceAndTargetData['count'];
                
                $totalRecordCount = $this->listTotalCount;
                $this->setPagination($this->pageNo, $limit, $totalRecordCount);
                
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