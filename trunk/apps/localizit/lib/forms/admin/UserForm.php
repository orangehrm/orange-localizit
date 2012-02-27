<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserForm
 *
 * @author waruni
 */
class UserForm extends BaseUserForm {

    /**
     * Define Parameters
     * @var <type>
     */
    private $userManagementService;
    private $authenticationService;

    /**
     * Get the User Management service.And bind with DAO class.
     * @return <type>
     */
    private function getUserManagementService() {
        $this->userManagementService = new UserManagementService();
        $this->userManagementService->setUserManagementDao(new UserManagementDao);
        return $this->userManagementService;
    }

    /**
     * Get Authentication service.
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
        $this->userManagementService = $this->getUserManagementService();
        parent::__construct();
        
    }

    /**
     * Configure settings;
     */
    public function configure() {

        $this->setWidgets(array(
            'user_id' => new sfWidgetFormInputHidden(),
            'first_name' => new sfWidgetFormInputText(array(), array('class' => 'text_input')),
            'last_name' => new sfWidgetFormInputText(array(), array('class' => 'text_input')),
            'email' => new sfWidgetFormInputText(array(), array('class' => 'text_input')),
            'login_name' => new sfWidgetFormInputText(array(), array('class' => 'text_input')),
            'password' => new sfWidgetFormInputPassword(array(), array('class' => 'text_input')),
            'confirm_password' => new sfWidgetFormInputPassword(array(), array('class' => 'text_input')),
            'user_languages' => new sfWidgetFormInputHidden(array(), array('class' => 'text_input')),
            'action' => new sfWidgetFormInputHidden(),
            'user_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserType'), 'add_empty' => false)),
        ));

        $this->setValidators(array(
            'first_name' => new sfValidatorString(array('max_length' => 250, 'required' => true), array('max_length' => 'Should Be Less Than 250 Characters', 'required' => 'Required')),
            'last_name' => new sfValidatorString(array('max_length' => 250, 'required' => true), array('max_length' => 'Should Be Less Than 250 Characters', 'required' => 'Required')),
            'email' => new sfValidatorEmail(array('required' => true), array('required' => 'Required', 'invalid' => 'Expected format: admin@example.com')),
            'login_name' => new sfValidatorString(array('min_length' => 6, 'max_length' => 25), array('required' => 'Required', 'min_length' => 'Should Be at Least 6 Characters', 'max_length' => 'Should Be Less Than 35 Characters')),
            'password' => new sfValidatorString(array('min_length' => 6, 'max_length' => 35), array('required' => 'Required', 'min_length' => 'Should Be at Least 6 Characters', 'max_length' => 'Should Be Less Than 35 Characters')),
            'confirm_password' => new sfValidatorString(array(), array('required' => 'Required')),
            'user_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserType'))),
        ));

        $this->widgetSchema->setNameFormat('user[%s]');

        $post_validator = new sfValidatorAnd();
        $post_validator->addValidator(new sfValidatorCallback(array('callback' => array($this, 'checkPostValidations'))));
        $this->validatorSchema->setPostValidator($post_validator);
        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', false);
    }

    /**
     *  Save records to database.
     * @return <type>
     */
    public function saveUser() {

        try {
            $userManagementService = $this->getUserManagementService();

            $values = $this->getValues();
;
            $addUser = $userManagementService->addUser($values['first_name'],$values['last_name'],$values['email'],$values['login_name'], $values['password'], $values['user_type_id']);

            if (isset($values['user_languages'])) {
                foreach ($values['user_languages'] as $id) {
                    $userLang = new UserLanguage();
                    $userLang->setUserId($addUser->getId());
                    $userLang->setLanguageId($id);
                    $userManagementService->addUserLang($userLang);
                }
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * Update Database
     */
    public function updateUser() {
        try {
            $userManagementService = $this->getUserManagementService();

            $values = $this->getValues();
            $user = new User();
            $user->setId($values['user_id']);
            $user->setUsername($values['login_name']);
            $user->setPassword($values['password']);
            $user->setUserTypeId($values['user_type_id']);

            $addUser = $userManagementService->updateUser($user);

            if (isset($values['user_languages'])) {
                $userManagementService->deleteUserLanguages($user->getId());
                foreach ($values['user_languages'] as $id) {
                    $userLang = new UserLanguage();
                    $userLang->setUserId($values['user_id']);
                    $userLang->setLanguageId($id);
                    $userManagementService->updateUserLang($userLang);
                }
            }
            if (($user->getUserType()->getUserType() == sfConfig::get('app_admin')) && (isset($values['user_languages']) && count($values['user_languages']) > 0)) {
                $userManagementService->deleteUserLanguages($user->getId());
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * Check username availability.
     */
    public function checkPostValidations($validator, $values) {
        $authenticationService = $this->getAuthenticationService();

        if ($values['action'] == 'add') {
            if ($authenticationService->getUserByName($values['login_name']) instanceof User) {
                throw new sfValidatorError($validator, 'Username Already Exists');
            } else if((strlen($values['password']) < 6)) {
                throw new sfValidatorError($validator, 'Password Length Should Be at Least 6 Characters');
            } else if (($values['confirm_password'] != $values['password'])) {
                throw new sfValidatorError($validator, 'Password and Confirm Password Do Not Match');
            }
        }
        return $values;
    }

}

