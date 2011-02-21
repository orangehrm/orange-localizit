<?php

/**
 * User form.
 *
 * @package    localizit
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserForm extends BaseUserForm {

    private $authenticationService;

    private function getAuthenticationService() {
        return $this->authenticationService;
    }

    public function __construct($authenticationService) {
        $this->authenticationService = $authenticationService;
        parent::__construct();
    }

    public function configure() {
        
        $this->setWidgets(array(
            'login_name' => new sfWidgetFormInputText(),
            'password' => new sfWidgetFormInputPassword()
        ));
        $this->setValidators(array(
            'login_name' => new sfValidatorString(array('required' => true)),
            'password' => new sfValidatorString(array('required' => true))
        ));
        $post_validator = new sfValidatorAnd();
        $post_validator->addValidator(new sfValidatorCallback(array('callback' => array($this, 'checkUserExists'))));

        $this->widgetSchema->setNameFormat('sign_in[%s]');
        $this->validatorSchema->setPostValidator($post_validator);
        
    }

    public function checkUserExists($validator, $values) {
        $authenticationService = $this->getAuthenticationService();
        if (empty($values['login_name'])) {
            throw new sfValidatorError($validator, 'Login name required');
        }

        if (empty($values['password'])) {
            throw new sfValidatorError($validator, 'Password required');
        }
        if (! empty($values['login_name']) && ! empty($values['password'])) {
            $existingUser = $authenticationService->getUserByName($values['login_name']);

            if($existingUser['password'] != md5($values['password'])){
                throw new sfValidatorError($validator, 'Invalid login');
            }
//            if (!$authenticationService->getUser($values['login_name'], $values['password']) instanceof User) {
//                throw new sfValidatorError($validator, 'Invalid login');
//            }
        }
        return $values;
    }

}