<?php

class saveTranslateTextAction extends sfAction {
    
    public function preExecute() {
        if(!$this->getUser()->isAuthenticated()) {
            $this->redirect('@loginpage');
        }
        $this->localizationService = new LocalizationService();
        $locaizationDao = new LocalizationDao();
        $this->localizationService->setLocalizationDao($locaizationDao);
    }
    
    public function execute($request){
        $targetLanguageId = $request->getParameter('languageList');
        $form = $request->getParameter('add_label');
        $languageGroupId = $form['language_group_id'];
        $targetLabels = $request->getParameter('targetLabel');
        $targetNotes = $request->getParameter('targetNote');
        foreach( $targetLabels as $sourcekey => $targetLabels) {
            $sourceId = $sourcekey;
            foreach ($targetLabels as $targetkey => $targetlabel) {
                if($targetkey > 0 ) {
                    if ($targetlabel != "") {
                        $target = new Target();
                        $target->setId($targetkey);
                        $target->setSourceId($sourceId);
                        $target->setLanguageId($targetLanguageId);
                        $target->setValue($targetlabel);
                        $target->setNote($targetNotes[$sourcekey][$targetkey]);
                        $this->localizationService->updateTarget($target);
                    } else {
                        $this->localizationService->deleteTarget($targetkey);
                    }
                } else if($targetkey == -1) {
                    if ($targetlabel != "") {
                        $target = new Target();
                        $target->setSourceId($sourceId);
                        $target->setLanguageId($targetLanguageId);
                        $target->setValue($targetlabel);
                        $target->setNote($targetNotes[$sourcekey][$targetkey]);
                        $this->localizationService->addTarget($target);
                    }
                }
            }
        }
    }
}