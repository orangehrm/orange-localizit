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
     * @param $tblName
     * @returns Array
     * @throws DaoException
     */
    public function getDataList($tblName) {
        try {
            if (is_string($tblName)) {
                $q = Doctrine_Query :: create()
                                ->from("$tblName l");
                return $q->execute();
            } else {
                throw new DaoException();
            }
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * get Source object By id
     * @param int $Id
     * @returns Source object
     * @throws DaoException
     */
    public function getSourceById($id) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('Source s')
                            ->where('s.id = ?', $id);

            return $q->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * get Source object By value
     * @param string $value
     * @returns Source Object
     * @throws DaoException
     */
    public function getSourceByValue($value) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('Source s')
                            ->where('s.value = ?', $value);

            return $q->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Save Source
     * @param Source $source
     * @throws DaoException
     */
    public function addSource(Source $source) {
        try {
            $source->save();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Update Source
     * @param Source $source
     * @returns Row count
     * @throws DaoException
     */
    public function updateSource(Source $source) {
        try {
            $q = Doctrine_Query :: create()
                            ->update('Source s')
                            ->set('s.value ', "\"{$source->getValue()}\"")
                            ->set('s.groupId ', "\"{$source->getGroupId()}\"")
                            ->set('s.note ', "\"{$source->getComment()}\"")
                            ->where('s.id = ?', $source->getId());
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Get Language By id
     * @param int $id
     * @returns Language object
     * @throws DaoException
     */
    public function getLanguageById($id) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('Language l')
                            ->where('l.id=?', $id);
            return $q->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Get Language By Code
     * @param string $code
     * @returns Language object
     * @throws DaoException
     */
    public function getLanguageByCode($code) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('Language l')
                            ->where('l.code=?', $code);
            return $q->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Retrive Target string list by target Language Id
     * @param int $targetLanguageId
     * @returns Collection
     * @throws DaoException
     */
    public function getLangStrByTargetIds($languageId) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('Target t')
                            ->where('t.language_id = ?', $languageId);
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Get Target String list by target language id and source group id.
     */
    public function getTargetStringByTargetAndSourceGroupId($languageId, $groupId) {
        try {
            $query = Doctrine_Query:: create ()
                            ->select('t.*, s.id')
                            ->from('Source s')
                            ->leftJoin('s.Target t')
                            ->where('s.group_id = ?', $groupId)
                            ->addWhere('t.language_id = ?', $languageId);
            return $query->execute();
        } catch (Exception $exp) {
            throw new DaoException($exp->getMessage());
        }
    }

    /**
     * Save Target
     * @param Target $target
     * @throws DaoException
     */
    public function addTarget(Target $target) {
        try {
            $target->save();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Update Target
     * @param Target $target
     * @returns boolean
     * @throws DaoException
     */
    public function updateTarget(Target $target) {
        try {
            $q = Doctrine_Query :: create()
                            ->update('Target t')
                            ->set('t.source_id ', $target->getSourceId())
                            ->set('t.language_id ', $target->getLanguageId())
                            ->set('t.value ', "\"{$target->getValue()}\"")
                            ->set('t.note ', "\"{$target->getNote()}\"")
                            ->where('t.id = ?', $target->getId());
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     *  Save Group.
     */
    public function addGroup(Group $group) {
        try {
            $group->save();
        } catch (Exception $ex) {
            throw new DaoException($ex->getMessage());
        }
    }

    /**
     * Update Group.
     */
    public function updateGroup(Group $group) {
        try {
            $q = Doctrine_Query :: create()
                            ->update('Group g')
                            ->set('g.name ', "\"{$group->getName()}\"")
                            ->where('g.id = ?', $group->getId());
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Get Group by id
     */
    public function getGroupById($id) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('Group g')
                            ->where('g.id=?', $id);
            return $q->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}

