<?php
/**
 * LocaliztionDao for CRUD operation
 *
 * @author Ruwan G
 */
class LocaliztionDao extends BaseDao {

    /**
     * Save Label
     * @param OhrmLabel $label
     * @returns boolean
     * @throws DaoException
     */
    public function addLabel(OhrmLabel $label) {
        try {
            $label->save();
            return true ;
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
                    ->from('OhrmLanguageLabelString lls')
                    ->innerJoin("lls.OhrmLabel label")
                    ->innerJoin("lls.OhrmLanguage language")
                    ->where('lls.language_id = ?', $languageId)
                    ->andWhere('lls.language_label_string_status=1')
                    ->andWhere('label.label_status=1')
                    ->andWhere('language.language_status=1')
                    ->orderBy('label.label_name');
            return $q->execute();
        } catch(Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
}

