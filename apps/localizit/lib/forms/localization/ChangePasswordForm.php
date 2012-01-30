<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChangePassword form
 *
 */
class ChangePasswordForm extends sfForm {

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
    
    public function __construct() {
        $this->authenticationService = $this->getAuthenticationService();
        $this->user = sfContext::getInstance()->getUser()->getAttribute('loginUser');
        parent::__construct();
    }
    /**
     * Configure the changePassword form . Set Validations.
     */
    public function configure() {

        $this->setWidgets(array(
            'id' => new sfWidgetFormInputHidden(array(), array('value' => $this->user->getId())),
            'current_password' => new sfWidgetFormInputPassword(array(), array('class' => 'text_input')),
            'new_password' => new sfWidgetFormInputPassword(array(), array('class' => 'text_input')),
            'confirm_new_password' => new sfWidgetFormInputPassword(array(), array('class' => 'text_input')),
        ));

        $this->setValidators(array(
            'id' => new sfValidatorNumber(array('required' => true)),
            'current_password' => new sfValidatorString(array('required' => true), array('required' => 'Current Password is required.')),
            'new_password' => new sfValidatorString(array('required' => true, 'min_length' => 6, 'max_length' => 35), array('required' => 'New Password is required.', 'min_length' => 'Password Length Should Be at Least 6 Characters', 'max_length' => 'Password Length Should Be Less Than 35 Characters')),
            'confirm_new_password' => new sfValidatorString(array('required' => true), array('required' => 'Confirm new password required.')),
        ));

        $this->widgetSchema->setNameFormat('changePassword[%s]');
        
        $post_validator = new sfValidatorAnd();
        $post_validator->addValidator(new sfValidatorCallback(array('callback' => array($this, 'checkPostValidations'))));
        $this->validatorSchema->setPostValidator($post_validator);
    }
    
    public function checkPostValidations($validator, $values) {
            $existingUser = $this->user;
            if ($existingUser->getPassword() != md5($values['current_password'])) {
                throw new sfValidatorError($validator, 'Invalid Current Password');
            } else if((strlen($values['new_password']) < 6)) {
                throw new sfValidatorError($validator, 'Password Length Should Be at Least 6 Characters');
            } else if (($values['confirm_new_password'] != $values['new_password'])) {
                throw new sfValidatorError($validator, 'New Password and New Confirm Password Do Not Match');
            }
        return $values;
    }
}
