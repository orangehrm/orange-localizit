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
     * get Source object By group id
     * @param integer groupId
     * @returns Source Object
     * @throws DaoException
     */
    public function getSourceByGroupId($gropuId) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('Source s')
                            ->where('s.groupId = ?', $gropuId);

            return $q->execute();
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
                            ->set('s.note ', "\"{$source->getNote()}\"")
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
     * Retrive Target list by target Language Id
     * @param int $languageId
     * @returns Collection
     * @throws DaoException
     */
    public function getTargetByLanguageId($languageId) {
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
     * Get Target String list by language id and source group id.
     * @param int $languageId, $groupId
     * @return Doctrine Collection
     * @throws Dao Exception
     */
    public function getTargetStringByLanguageAndSourceGroupId($languageId, $groupId) {
        try {
            $query = Doctrine_Query:: create ()
                            ->select('t.*, s.*')
                            ->from('Source s')
                            ->leftJoin('s.Target t')
                            ->addWhere('s.group_id = ?', $groupId)
                            ->orderBy('s.value');
            $sourceList = $query->execute();
    
            foreach ($sourceList as $source) {
                $targets = $source->getTarget();
                foreach ($targets as $key => $target) {
                    if($target->getLanguageId() != $languageId ){
                        $source->getTarget()->remove($key);
                        
                    }
                }
            }
            return $sourceList;
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
                            ->set('t.sourceId ', $target->getSourceId())
                            ->set('t.languageId ', $target->getLanguageId())
                            ->set('t.value ', "\"{$target->getValue()}\"")
                            ->set('t.note ', "\"{$target->getNote()}\"")
                            ->where('t.id = ?', $target->getId());
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Delete Target
     * @param $id
     * @return deleted record type
     */
    public function deleteTarget($id) {
        try {
                $q = Doctrine_Query::create()
                        ->delete('Target t')
                        ->where('t.id = ?', $id);
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    /**
     *  Save Group.
     *  @param Group group
     *  @throws Dao Exception
     */
    public function addGroup(Group $group) {
        try {
            $group->save();
        } catch (Exception $ex) {
            throw new DaoException($ex->getMessage());
        }
    }

    /**
     * Update Group
     * @param Group $group
     * @return update row count
     * @throws Dao Exception
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
     * @param integer $id
     * @return Doctrine collection
     * @throws Dao Exception
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
   
        /**
     * Get Language List for user
     * @returns Language Collection
     * @return Language
     */
    public function getUserLanguageList($ids) {
        try {
            $q = Doctrine_Query :: create()
                            ->select('u.languageId')
                            ->from('userLanguage u')
                            ->whereIn('u.id', $ids);
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    /**
     * Retrive language string list by source and target Language Id
     * @param int $sourceLanguageId, int $targetLanguageId
     * @returns Collection
     * @throws DaoException
     */
    public function getLangStrBySrcAndTargetIds($sourceLanguageId, $targetLanguageId) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('Target lls')
                            ->whereIn('lls.id', array($sourceLanguageId, $targetLanguageId));
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    /**
     * Delete By sourceId
     * @param int $sourceId
     * @returns delete row count
     * @throws DaoException
     */
    public function deleteSourceById($sourceId) {
        try {
            $q = Doctrine_Query :: create()
                            ->delete('Source')
                            ->from('Source s')
                            ->whereIn('s.id', $sourceId);
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    /**
     * Retrieve all the Source Values
     * @returns Source Value arraylist
     * @throws DaoException
     */
    public function getSourceList() {
        try {
            $q = Doctrine_Query :: create()
                            ->select('value')
                            ->from('Source l');
            return $q->fetchArray();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    
    /**
     * Retrieve all the Source Values
     * @param integet $groupId
     * @returns Source Values arraylist
     * @throws DaoException
     */
    public function getSourceListByGroupId($groupid) {
        try {
            $q = Doctrine_Query :: create()
                            ->select('value')
                            ->from('Source l')
                            ->whereIn('l.group_id', $groupid);
            return $q->fetchArray();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    /**
     * get Source object By Value
     * @param string $sourceValue
     * @returns Source Object
     * @throws DaoException
     */
    public function getSourceIdByValue($sourceValue) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('Source')
                            ->select('id')
                            ->where('value = ?', $sourceValue);

            return $q->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
    /**
     * get Source by source and group id
     * @param integer $groupId $sourceValue
     * @returns Source Object
     * @throws DaoException
     */
    public function getSourceIdByByGroupIdValue($groupId , $sourceValue) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('Source')
                            ->select('id')
                            ->where('value = ? AND group_id = ?',array($sourceValue, $groupId));

            return $q->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
    
}

