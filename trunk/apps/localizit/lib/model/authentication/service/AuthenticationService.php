<?php
/**
 * AuthenticationService for User operation
 *
 * @author Chameera S
 */
class AuthenticationService extends BaseService {

    private $authenticationDao;

    public function getAuthenticationDao() {
        return $this->authenticationDao;
    }

    public function setAuthenticationDao(AuthenticationDao $authenticationDao) {
        $this->authenticationDao = $authenticationDao;
    }

    /**
     * Get user
     * @param $userName
     * @throws ServiceException
     * @return User
     */
    public function getUserByName($userName) {
        $authenticationDao = $this->getAuthenticationDao();
        try {
            return $authenticationDao->getUserByName($userName);
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

    /**
     * Get User
     * @param <type> $userName
     * @param <type> $password
     * @return <type> user
     */

    public function getUser($userName, $password) {
        $authenticationDao = $this->getAuthenticationDao();
        try {
            return $authenticationDao->getUser($userName, $password);
        } catch (Exception $exc) {
            throw new ServiceException($exc->getMessage(), $exc->getCode());
        }
    }

}