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
 * Description of SignInForm
 *
 * @author waruni
 */
class SignInForm extends BaseUserForm {

    /**
     * Define Parameters
     * @var <type> 
     */
    private $authenticationService;


    /**
     * Get the Authentication service.And bind with DAO class.
     * @return <type> 
     */
    private function getAuthenticationService() {
        $this->authenticationService = new AuthenticationService();
        $this->authenticationService->setAuthenticationDao(new AuthenticationDao());
        return $this->authenticationService;
    }
    
    /**
     * Constructor. Initialization Authentication Service.
     */
    public function __construct() {
        $this->authenticationService = $this->getAuthenticationService();
        parent::__construct();
    }

    /**
     * Configure the signin form . Set Validations.
     */
    public function configure() {

        $this->setWidgets(array(
            'loginName' => new sfWidgetFormInputText(),
            'password' => new sfWidgetFormInputPassword()
        ));
        $this->widgetSchema->setNameFormat('sign_in[%s]');
        $this->setValidators(array(
            'loginName' => new sfValidatorString(array(), array('required' => 'Username is required')),
            'password' => new sfValidatorString(array(), array('required' => 'Password is required'))
        ));
        $post_validator = new sfValidatorAnd();
        $post_validator->addValidator(new sfValidatorCallback(array('callback' => array($this, 'checkUserExists'))));

        $this->validatorSchema->setPostValidator($post_validator);
    }

    /**
     * Check whether user exists.
     * @param <type> $validator
     * @param <type> $values
     * @return <type> 
     */
    public function checkUserExists($validator, $values) {

        if (!empty($values['loginName']) && !empty($values['password'])) {
            $existingUser = $this->authenticationService->getUserByName($values['loginName']);

            if ($existingUser['password'] != md5($values['password'])) {
                throw new sfValidatorError($validator, 'Invalid login');
            }
        }
        return $values;
    }

}