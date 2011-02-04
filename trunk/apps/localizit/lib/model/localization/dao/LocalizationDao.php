<?php
/**
 * LocalizationDao for CRUD operation
 *
 * @author Ruwan G
 */
class LocalizationDao extends BaseDao {

    /**
     * get All Labels
     * @returns Label Collection
     * @throws DaoException
     */
    public function getLabelList() {
        try {
            $q = Doctrine_Query :: create()
                    ->from('Label l');
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
            $label->replace();
            return true;
        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    /**
     * Get Language List
     * @returns Language Collection
     * @throws DaoException
     */
    public function getLanguageList() {
        try {
            $q = Doctrine_Query :: create()
                    ->from('Language l');
            return $q->execute();
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
            $lls->replace();
            return true;
        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
}

