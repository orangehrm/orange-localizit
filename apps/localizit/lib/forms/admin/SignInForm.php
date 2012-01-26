<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SignInForm
 *
 * @author waruni
 */
class SignInForm extends BaseForm {

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
            'loginName' => new sfWidgetFormInputText(array(), array('class' => 'text_input')),
            'password' => new sfWidgetFormInputPassword(array(), array('class' => 'text_input'))
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
                throw new sfValidatorError($validator, 'Invalid Username or Password');
            } else {
                sfContext::getInstance()->getUser()->setAttribute('loginUser', $existingUser);
                if ($existingUser->getUserTypeId() == 1)
                    sfContext::getInstance()->getUser()->addCredential('Admin');
                if ($existingUser->getUserTypeId() == 2)
                    sfContext::getInstance()->getUser()->addCredential('Moderator');
            }
        }
        return $values;
    }

}
