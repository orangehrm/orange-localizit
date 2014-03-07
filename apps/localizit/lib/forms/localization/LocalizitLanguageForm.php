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
class LocalizitLanguageForm extends sfForm {
    
    private $languageService;
    
    public function getLanguageService() {
        if(is_null($this->languageService)){
            $this->languageService = new LanguageService();
            $this->languageService->setLanguageDao(new LanguageDao());
        }
        return $this->languageService;
    }    

    public function configure() {
        $languageId = $this->getOption('langId');
               
        $this->setWidgets($this->getFormWidgets());
        
        $this->setValidators($this->getFormValidators());
        
        if ($languageId != null) {
            $this->setDefaultValues($languageId);
        }
        $this->widgetSchema->setNameFormat('language[%s]');
        
    }
    
    public function getFormWidgets(){
        $widgets = array();
        $widgets['id'] = new sfWidgetFormInputHidden();
        $widgets['name'] = new sfWidgetFormInputText();
        $widgets['code'] = new sfWidgetFormInputText();
        
        return $widgets;
    }
    
    public function getFormValidators() {
        $validators = array();
        $validators['id'] = new sfValidatorNumber(array('required' => false));
        $validators['name'] = new sfValidatorString(array('required' => 'Language name required.', 'max_length' => 255));
        $validators['code'] = new sfValidatorString(array('required' => 'Language code required.', 'max_length' => 255));
        
        return $validators;
    }
    
    public function setDefaultValues($langId){
        $language = $this->getLanguageService()->getLanguageById($langId);
        $this->setDefault('id', $langId);
        $this->setDefault('name', $language->getName());
        $this->setDefault('code', $language->getCode());
    }
    
    public function save() {
        $langId = $this->getValue('id');
        
        if(!empty($langId)){
            $language = $this->getLanguageService()->getLanguageById($langId);
        }else{
            $language = new Language();
        }
        $language->setName($this->getValue('name'));
        $language->setCode($this->getValue('code'));
        
        $result = $this->getLanguageService()->saveLanguage($language);
        return $result;
        
    }

}
