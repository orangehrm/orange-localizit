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
     * @returns Label Collection
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
     * @returns Label Collection
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
     * @returns Label
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
     * Retrive Label and language string list
     * @param int $languageId
     * @returns Collection
     * @throws DaoException
     */
    public function getLabelAndLanguageStrings($languageId) {
        try {
            $q = Doctrine_Query :: create()
                    ->from('LanguageLabelString lls')
                    ->innerJoin("lls.Label label")
                    ->innerJoin("lls.Language language")
                    ->where('lls.language_id = ?', $languageId)
                    ->andWhere('lls.language_label_string_status=?',sfConfig::get('app_status_enabled'))
                    ->andWhere('label.label_status=?',sfConfig::get('app_status_enabled'))
                    ->andWhere('language.language_status=?',sfConfig::get('app_status_enabled'))
                    ->orderBy('label.label_name');
            return $q->execute();
        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }


    /**
     * Get Language List
     * @param Label $label
     * @returns Label
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

}

