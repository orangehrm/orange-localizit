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
 * Description of UserManagementDao
 *
 * @author waruni
 */
class UserManagementDao extends BaseDao {

    /**
     * Add user method
     */
    public function addUser(User $user) {
        try {
            $user->save();
            return $user;
        } catch (Exception $exception) {
            throw new DaoException($exception->getMessage());
        }
    }

    /**
     * Add User Language
     */
    public function addUserLang(UserLanguage $userLang) {
        try {
            $userLang->save();
            return $userLang;
        } catch (Exception $exception) {
            throw new DaoException($exception->getMessage());
        }
    }

    /**
     * Update user method
     */
    public function updateUser(User $user) {
        try {
            $query = Doctrine_Query::create()
                            ->update('User u')
                            ->set('u.login_name ', "\"{$user->getLoginName()}\"")
                            ->set('u.password', "\"{$user->getPassword()}\"")
                            ->set('u.user_type_id', "\"{$user->getUserTypeId()}\"")
                            ->where('u.user_id = ?', $user->getUserId())
                            ->execute();
            return true;
        } catch (Exception $exception) {
            throw new DaoException($exception->getMessage());
        }
    }

    /**
     * Delete user method.
     */
    public function deleteUser($userId) {
        try {
            $user = $this->getUserById($userId);
            $this->deleteUserLanguages($userId);
            $user->delete();
            return true;
        } catch (Exception $exception) {
            throw new DaoException($exception->getMessage());
        }
    }

    /**
     * Delete user languages.
     */
    public function deleteUserLanguages($userId) {
        try {

            $q = Doctrine_Query :: create()
                            ->delete()
                            ->from('UserLanguage l')
                            ->where('l.user_id = ?', $userId);
            $q->execute();
            return true;
        } catch (Exception $exception) {
            throw new DaoException($exception->getMessage());
        }
    }

    /**
     * Get User by ID. Return User Object.
     */
    public function getUserById($userId) {
        try {
            $query = Doctrine_Query :: create()
                            ->from('User u')
                            ->where('u.user_id = ?', $userId);

            return $query->fetchOne();
        } catch (Exception $exception) {
            throw new DaoException($exception->getMessage());
        }
    }

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
     * Get Language list by user id
     * @param int $userId
     * @returns Language id list
     * @throws DaoException
     */
    public function getUserLanguageList($userId) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('UserLanguage l')
                            ->where('l.user_id = ?', $userId);
            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

}