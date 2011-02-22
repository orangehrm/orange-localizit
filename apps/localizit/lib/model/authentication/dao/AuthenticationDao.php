<?php

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

}
