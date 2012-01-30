<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class LabelUploadForm extends sfForm
{
    private $localizeService;

    private function getLocalizeService() {
        return $this->localizeService;
    }
    public function __construct($localizeService) {
        $this->localizeService = $localizeService;
        parent::__construct();
    }
    public function configure() {

    $localService = $this->getLocalizeService();
    $languageGroupArray = $localService->getGroupList();
    $targetLanguageArray = $localService->getLanguageList();
    
    
    
    $lanGroups = array('' => "-- " . ('Select') . " --");
     foreach ($languageGroupArray as $type) {
            $lanGroups[$type->getId()] = $type->getName();
        }
    
    $targetLan = array('' => "-- " . ('Select') . " --");
    foreach ($targetLanguageArray as $type) {
            if($type->getCode() != 'en_US') {
                $targetLan[$type->getId()] = $type->getName(). " (".$type->getCode().")" ;
            }
        }
        
    $this->setWidgets(array(
      'Language_group'   => new sfWidgetFormSelect(array('label' => 'Language Group', 'choices' => $lanGroups)),
        
      'Target_language' => new sfWidgetFormSelect(array('label' => 'Target Language','choices' => $targetLan)),
      'Include_target_value' => new sfWidgetFormInputCheckbox(array('label' => 'Include Target Value'),array('class' => 'text_input')),
      'Target_note' => new sfWidgetFormTextarea(array('label' => 'Target Note'),array('class' => 'text_input')),
      'File' => new sfWidgetFormInputFile()
    ));
 
    $this->setValidators(array(
      'Language_group'   => new sfValidatorString(array('required' => false)),
      'Target_language' => new sfValidatorString(array('required' => false , 'max_length' => 255)),
      'Include_target_value' => new sfValidatorString(array('required' => false)),
      'Target_note' => new sfValidatorString(array('required' => false)),
      'File' => new sfValidatorFile(array('max_size' => 5000000   ,'required' => false, 'path' => sfConfig::get('sf_upload_dir')))
    ));
    
    $this->widgetSchema->setNameFormat('uploadForm[%s]');
    }

}

?>
