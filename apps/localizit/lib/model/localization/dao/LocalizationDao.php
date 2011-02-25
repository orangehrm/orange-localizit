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
 * LocalizationDao for CRUD operation
 *
 * @author Ruwan G
 */
class LocalizationDao extends BaseDao {

    /**
     * get All Records From a table
     * @param String $tblName
     * @returns Data Collection
     * @throws DaoException
     */
    public function getDataList($tblName) {
        try {
            $q = Doctrine_Query :: create()
                    ->from($tblName.' l');
            return $q->execute();

        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * get Label object By Lable Id
     * @param int $labelId
     * @returns Label object
     * @throws DaoException
     */
    public function getLabelById($labelId) {
        try {
            $q = Doctrine_Query :: create()
                    ->from('Label l')
                    ->where('l.label_id = ?', $labelId);

            return $q->fetchOne();

        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * get Label object By name
     * @param string $labelName
     * @returns Label Object
     * @throws DaoException
     */
    public function getLabelByName($labelName) {
        try {
            $q = Doctrine_Query :: create()
                    ->from('Label l')
                    ->where('l.label_name = ?', $labelName);

            return $q->fetchOne();

        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Save Label
     * @param Label $label
     * @returns Label object
     * @throws DaoException
     */
    public function addLabel(Label $label) {
        try {
            $label->save();
            return $label ;
        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Update Label
     * @param Label $label
     * @returns boolean
     * @throws DaoException
     */
    public function updateLabel(Label $label) {
        try {
            $q = Doctrine_Query :: create()
                    ->update('Label l')
                    ->set('l.label_name ',"\"{$label->getLabelName()}\"")
                    ->set('l.label_comment ',"\"{$label->getLabelComment()}\"")
                    ->set('l.label_status ',"\"{$label->getLabelStatus()}\"")
                    ->where('l.label_id = ?', $label->getLabelId())
                    ->execute();
            return true;
        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Get Language By id
     * @param int $languageId
     * @returns Language object
     * @throws DaoException
     */
    public function getLanguageById($languageId) {
        try {
            $q = Doctrine_Query :: create()
                    ->from('Language l')
                    ->where('l.language_id=?', $languageId);
            return $q->fetchOne();
        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Get Language By Code
     * @param string $languageCode
     * @returns Language object
     * @throws DaoException
     */
    public function getLanguageByCode($languageCode) {
        try {
            $q = Doctrine_Query :: create()
                    ->from('Language l')
                    ->where('l.language_code=?', $languageCode);
            return $q->fetchOne();
        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Retrive language string list by source and target Language Id
     * @param int $sourceLanguageId, int $targetLanguageId
     * @returns Collection
     * @throws DaoException
     */
    public function getLangStrBySrcAndTargetIds($sourceLanguageId,$targetLanguageId) {
        try {
            $q = Doctrine_Query :: create()
                    ->from('LanguageLabelString lls')
                    ->whereIn('lls.language_id', array($sourceLanguageId,$targetLanguageId));
            return $q->execute();

        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Create Language String
     * @param LanguageLabelString $lls
     * @returns LanguageLabelString
     * @throws DaoException
     */
    public function addLangStr(LanguageLabelString $lls) {
        try {
            $lls->save();
            return $lls;
        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Update Language String
     * @param LanguageLabelString $lls
     * @returns boolean
     * @throws DaoException
     */
    public function updateLangStr(LanguageLabelString $lls) {
        try {
            $q = Doctrine_Query :: create()
                    ->update('LanguageLabelString lls')
                    ->set('lls.label_id ',$lls->getLabelId())
                    ->set('lls.language_id ',$lls->getLanguageId())
                    ->set('lls.language_label_string ',"\"{$lls->getLanguageLabelString()}\"")
                    ->set('lls.language_label_string_status ',"\"{$lls->getLanguageLabelStringStatus()}\"")
                    ->where('lls.language_label_string_id = ?', $lls->getLanguageLabelStringId())
                    ->execute();
            return true;
        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
}

