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
 * LanguageDao for CRUD operations
 * 
 */
class LanguageDao extends BaseDao {

    /**
     * Get Lnaguage by Id
     * 
     * @param type $id
     * @return Language object
     * @throws DaoException
     */
    public function getLanguageById($id) {
        try {
            $result = Doctrine::getTable('Language')->find($id);
            return $result;
            //@codeCoverageIgnoreStart
        } catch (Exception $ex) {
            throw new DaoException($ex->getMessage(), $ex->getCode(), $ex);
        }//@codeCoverageIgnoreEnd
    }

    /**
     * Get Language List
     * 
     * @return Doctrine Collection
     * @throws DaoException
     */
    public function getLanguageList($userLanguage) {

        try {
            $q = Doctrine_Query :: create()
                    ->from("Language")
                    ->whereNotIn('id',$userLanguage)
                    ->orderBy("name");
            return $q->execute();
            //@codeCoverageIgnoreStart
        } catch (Exception $ex) {
            throw new DaoException($ex->getMessage(), $ex->getCode(), $ex);
        }//@codeCoverageIgnoreEnd
    }

    /**
     * Save a language
     * @param Language $language
     * @return Language
     * @throws DaoException
     */
    public function saveLanguage(Language $language) {
        try {
            $language->save();
            return $language;
            //@codeCoverageIgnoreStart
        } catch (Exception $ex) {
            throw new DaoException($ex->getMessage(), $ex->getCode(), $ex);
        }//@codeCoverageIgnoreEnd
    }

    /**
     * Delete a language by id
     * 
     * @param type $id
     * @return type
     * @throws DaoException
     */
    public function deleteLanguageById($id) {
        try {
            $query = Doctrine_Query::create()
                    ->delete('Language')
                    ->where('id=?', $id);
            return $query->execute();
            //@codeCoverageIgnoreStart
        } catch (Exception $ex) {
            throw new DaoException($ex->getMessage(), $ex->getCode(), $ex);
        }//@codeCoverageIgnoreEnd
    }

}
