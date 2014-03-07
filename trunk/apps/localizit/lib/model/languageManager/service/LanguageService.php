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
 * LanguageService for CRUD operations
 * 
 */
class LanguageService extends BaseService{
    private $languageDao;
    
    public function getLanguageDao() {
        return $this->languageDao;
    }

    public function setLanguageDao(LanguageDao $languageDao) {
        $this->languageDao = $languageDao;
    }
    
    /**
     * Get a language by id
     * 
     * @param type $id
     * @return Language object
     */
    public function getLanguageById($id) {
        return $this->getLanguageDao()->getLanguageById($id);
    }
    
    /**
     * Get language list
     * @return Doctrine_Collection
     */
    public function getLanguageList() {
        return $this->getLanguageDao()->getLanguageList();
    }
    
    /**
     * Save a language
     * 
     * @param Language $language
     * @return Language
     */
    public function saveLanguage(Language $language) {
        return $this->getLanguageDao()->saveLanguage($language);
    }
    
    /**
     * Delete a language
     * 
     * @param type $id
     * @return int
     */
    public function deleteLanguageById($id) {
        return $this->getLanguageDao()->deleteLanguageById($id);
    }


}
