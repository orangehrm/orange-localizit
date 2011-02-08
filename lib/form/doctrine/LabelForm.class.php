<?php

/**
 * Label form.
 *
 * @package    localizit
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LabelForm extends sfForm {
    private $localizeService;

    private function getLocalizeService() {
        return $this->localizeService;
    }
    public function __construct($localizeService) {
        $this->localizeService = $localizeService;
        parent::__construct();
    }
    public function configure() {
        $this->setWidgets(array(
                'label_name'    => new sfWidgetFormInputText(),
                'label_local_language_string' => new sfWidgetFormInputText(),
                'label_comment' => new sfWidgetFormTextarea(),
                'addLabel'     => new sfWidgetFormInputHidden(array(),array('value'=>'true')),
        ));

        $this->setValidators(array(
                'label_name'    => new sfValidatorString(array('max_length' => 45, 'required' => true)),
                'label_local_language_string'    => new sfValidatorString(array('max_length' => 45, 'required' => true)),
                'label_comment' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
        ));

        $post_validator = new sfValidatorAnd();
        $post_validator->addValidator(new sfValidatorCallback(array('callback' => array($this, 'checkDuplicateLabel'))));
        
        $this->validatorSchema->setPostValidator($post_validator);


        $this->widgetSchema->setNameFormat('add_label[%s]');

        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', false);
    }
    public function checkDuplicateLabel($validator, $values) {

        $localizationService=$this->getLocalizeService();

        if(empty($values['label_name'])) {
            throw new sfValidatorError($validator, 'Label value required');
        }

        if(empty($values['label_local_language_string'])) {
            throw new sfValidatorError($validator, 'Label translation required');
        }

        if($localizationService->getLabelByName($values['label_name']) instanceof Label) {
            throw new sfValidatorError($validator, 'Label already exists');
        }

        return $values;
    }

    public function saveToDb() {

        try {
            $localizationService=$this->getLocalizeService();

            $values=$this->getValues();

            $addLabel=$localizationService->addLabel($values['label_name'],$values['label_comment']);

            $lls=new LanguageLabelString();
            $lls->setLabelId($addLabel->getLabelId());
            $lls->setLanguageId(sfContext::getInstance()->getUser()->getAttribute('user_language_id'));
            $lls->setLanguageLabelStringStatus(sfConfig::get('app_status_enabled'));
            $lls->setLanguageLabelString($values['label_local_language_string']);
            $localizationService->addLangStr($lls);

            return true;

        } catch(Exception $exc) {
            return false;
        }
    }
}
