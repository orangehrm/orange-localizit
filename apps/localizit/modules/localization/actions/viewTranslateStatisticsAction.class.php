<?php

/**
 * Description of viewTranslateStatisticsAction
 *
 */
class viewTranslateStatisticsAction extends sfAction {
    
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
        $defaults = $this->getSearchFilters();
        $this->searchFiltersForm = new TranslateSearchFiltersForm($defaults);
        $this->showSearchFilters = false;
        $this->pageNo = $request->getParameter('pageNo', 1);
        $limit = sfConfig::get('app_items_per_page');
        $this->offset = ($this->pageNo >= 1) ? (($this->pageNo - 1) * $limit) : 0;
        $this->listValues = array();
        
        $this->sourceWordCount = 0;
        $this->targetWordCount = 0;
        $this->sourceStringCount = 0;
        $this->targetStringCount = 0;
        $this->remainigStringCount = 0;
        $this->translatePresntage = 0;
        
        if ($request->isMethod(sfRequest::POST)) {
            $this->targetLanguageId = $request->getParameter('languageList');
            $form = $request->getParameter('add_label');
            $this->languageGroupId = $form['language_group_id'];
            if(($this->targetLanguageId == 0) || ($this->languageGroupId == 0)) {
                $this->getUser()->setFlash('errorMessage', "Select Valid Target Language and Language Group", false);
            } else {
                $searchParams = $request->getParameter($this->searchFiltersForm->getName());
                $this->setSearchFilters($searchParams);
                $searchParams = $this->getSearchFilters();
                $sourceAndTargetData = $this->getLocalizeService()->getSourceAndTargetListAsArray($this->targetLanguageId, $this->languageGroupId, null, 0,$searchParams);
                
                //print_r($searchParams);
                $this->listValues = $sourceAndTargetData['data'];
                foreach ($this->listValues  as $value) {
                   $this->sourceWordCount += str_word_count($value["sourceValue"]);
                   $this->targetWordCount += str_word_count($value["targetValue"]);
                   $this->sourceStringCount += 1;
                   if(isset($value["targetValue"]) && $value["targetValue"] !=''){
                     $this->targetStringCount += 1;
                   }
                }
                if(isset($searchParams['translated']) && $searchParams['translated'] ==0 ){
                    
                    $this->translatePresntage = ($this->targetWordCount / $this->sourceWordCount ) * 100  ;
                }
                $this->remainigStringCount =  $this->sourceStringCount -  $this->targetStringCount;
                
                $this->listTotalCount = $sourceAndTargetData['count'];
                
                $totalRecordCount = $this->listTotalCount;
                $this->setPagination($this->pageNo, $limit, $totalRecordCount);
                $this->showSearchFilters = true;
                $this->searchFiltersForm = new TranslateSearchFiltersForm($searchParams);
                if(count($this->listValues) == 0) {
//                    $this->showSearchFilters = false;
//                    $this->setSearchFilters(null);
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
    
    private function getSearchFilters(){
        $filers = $this->getUser()->getAttribute('search_filters');
        if(!is_array($filers)){
            $filers =array();
        }
        if(!isset($filers['translated'])){
            $filers['translated'] = 0;
        }
        return $filers;
    }
    private function setSearchFilters($filers){
        $this->getUser()->setAttribute('search_filters', $filers);
    }
}