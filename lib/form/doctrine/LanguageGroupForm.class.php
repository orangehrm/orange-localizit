<?php

/**
 * LanguageGroup form.
 *
 * @package    localizit
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LanguageGroupForm extends BaseLanguageGroupForm {

    private $localizationService;

    public function getLocalizationService() {
        $this->localizationService = new LocalizationService();
        $this->localizationService->setLocalizationDao(new LocalizationDao());
        return $this->localizationService;
    }

    public function configure() {

        $this->setWidgets(array(
            'group_name' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'group_name' => new sfValidatorString(array(), array('required' => 'Group name required.')),
        ));

        $this->widgetSchema->setNameFormat('add_language_group[%s]');

        $post_validator = new sfValidatorAnd();
//        $post_validator->addValidator(new sfValidatorCallback(array('callback' => array($this, 'checkDuplicates'))));

//        $this->validatorSchema->setPostValidator($post_validator);
    }

    /**
     *  Save records to database.
     * @return <type>
     */
    public function saveToDb() {

        try {
            $localizationService = $this->getLocalizationService();

            $values = $this->getValues();

            $addUser = $localizationService->addLanguageGroup($values['group_name']);

            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    /**
     * Check for duplicates entry.
     */
    public function checkDuplicates($validator, $values){
        
    }

}
