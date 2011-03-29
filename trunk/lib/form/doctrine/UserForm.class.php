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
            'login_name' => new sfWidgetFormInputText(),
            'password' => new sfWidgetFormInputPassword(),
            'user_languages' => new sfWidgetFormInputHidden(),
            'user_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserType'), 'add_empty' => false)),
        ));

        $this->setValidators(array(
//            'user_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user_id')), 'empty_value' => $this->getObject()->get('user_id'), 'required' => false)),
            'login_name' => new sfValidatorString(array(), array('required' => 'Username required.', 'max_length' => 25)),
            'password' => new sfValidatorString(array(), array('required' => 'Password required.', 'max_length' => 25)),
            'user_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserType'))),
        ));

        $this->widgetSchema->setNameFormat('user[%s]');

        $post_validator = new sfValidatorAnd();
        $post_validator->addValidator(new sfValidatorCallback(array('callback' => array($this, 'checkDuplicateUsername'))));
        $this->validatorSchema->setPostValidator($post_validator);
        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', false);
    }

    /**
     *  Save records to database.
     * @return <type>
     */
    public function saveToDb() {

        try {
            $userManagementService = $this->getUserManagementService();

            $values = $this->getValues();

            $addUser = $userManagementService->addUser($values['login_name'], $values['password'], $values['user_type_id']);

            if (isset($values['user_languages'])) {
                foreach ($values['user_languages'] as $id) {
                    $userLang = new UserLanguage();
                    $userLang->setUserId($addUser->getUserId());
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
    public function updateDb() {
        try {
            $userManagementService = $this->getUserManagementService();

            $values = $this->getValues();
            $user = new User();
            $user->setUserId($values['user_id']);
            $user->setLoginName($values['login_name']);
            $user->setPassword($values['password']);
            $user->setUserTypeId($values['user_type_id']);

            $addUser = $userManagementService->updateUser($user);

            if (isset($values['user_languages'])) {
                foreach ($values['user_languages'] as $id) {
                    $userLang = new UserLanguage();
                    $userLang->setUserId($values['user_id']);
                    $userLang->setLanguageId($id);
                    $userManagementService->updateUserLang($userLang);
                }
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * Check username availability.
     */
    public function checkDuplicateUsername($validator, $values) {
        $authenticationService = $this->getAuthenticationService();

//        if ((empty($values['user_id'])) && ($authenticationService->getUserByName($values['login_name']) instanceof User)) {
//            throw new sfValidatorError($validator, 'Username already exists');
//        }
        return $values;
    }

}
