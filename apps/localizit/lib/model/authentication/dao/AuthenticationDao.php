<?php

/**
 * Orange-localizit  is a System that transalate text into a any language.
 * Copyright (C) 2006 Orange-localizit Inc., http://www.orange-localizit.com
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
 * AuthenticationDao for User operation
 *
 * @author Chameera S
 */
class AuthenticationDao extends BaseDao {

    /**
     * get User object By name
     * @param string $userName
     * @returns User Object
     * @throws DaoException
     */
    public function getUserByName($userName=NULL) {
        try {
            $q = Doctrine_Query :: create()
                            ->from('User u')
                            ->where('u.login_name = ?', $userName);

            return $q->fetchOne();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * get User types
     * @returns UserType list
     * @throws DaoException
     */
    public function getUserTypeList() {
        try {
            $q = Doctrine_Query :: create()
                            ->from('UserType u');

            return $q->execute();
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }

    /**
     * Save User
     * @param User $user
     * @returns User object
     * @throws DaoException
     */
    public function addUser(User $user) {
        try {
            $user->save();
            return $user;
        } catch (Exception $e) {
            throw new DaoException($e->getMessage());
        }
    }
}