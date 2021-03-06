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

/**
 * Action class for view the language list
 * 
 */
class viewLanguageListAction extends sfAction {

    private $languageService;
    
    public function getLanguageService() {
        if(is_null($this->languageService)){
            $this->languageService = new LanguageService();
            $this->languageService->setLanguageDao(new LanguageDao());
        }
        return $this->languageService;
    }

    public function execute($request) {
        if (!$this->getUser()->isAuthenticated()) {
            $this->redirect('@loginpage');
        }
        $userLanguage = $this->getUser()->getAttribute('user_language_id');
        $this->languageList = $this->getLanguageService()->getLanguageList($userLanguage);
    }

}
