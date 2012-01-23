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
    
    public function configure(){
        $localService = $this->getLocalizeService();
        $languageGroupArray = $localService->getGroupList();
        
        $lanGroups = array('' => "-- " . ('Select') . " --");
        foreach ($languageGroupArray as $type) {
            $lanGroups[$type->getId()] = $type->getName();
        }
        
        $this->setWidgets(array(
            'Label' => new sfWidgetFormInput(array(), array('class' => 'text_input')),
            'Language_group' => new sfWidgetFormSelect(array('choices' => $lanGroups)),
            'Label_note' => new sfWidgetFormTextarea(array(), array('class' => 'text_input'))
        ));

        $this->setValidators(array(
            'Label' => new sfValidatorString(array('required' => false, 'max_length' => 255)),
            'Language_group' => new sfValidatorString(array('required' => false)),
            'Label_note' => new sfValidatorString(array('required' => false))
        ));

        $this->widgetSchema->setNameFormat('addSourceForm[%s]');
    }
}
