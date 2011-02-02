<?php

/**
 * OhrmLanguageLabelString form base class.
 *
 * @method OhrmLanguageLabelString getObject() Returns the current form's model object
 *
 * @package    localizit
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseOhrmLanguageLabelStringForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'language_label_string_id'     => new sfWidgetFormInputHidden(),
      'label_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OhrmLabel'), 'add_empty' => false)),
      'language_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OhrmLanguage'), 'add_empty' => false)),
      'language_label_string'        => new sfWidgetFormInputText(),
      'language_label_string_status' => new sfWidgetFormChoice(array('choices' => array(0 => '0', 1 => '1'))),
    ));

    $this->setValidators(array(
      'language_label_string_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'language_label_string_id', 'required' => false)),
      'label_id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('OhrmLabel'))),
      'language_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('OhrmLanguage'))),
      'language_label_string'        => new sfValidatorString(array('max_length' => 45)),
      'language_label_string_status' => new sfValidatorChoice(array('choices' => array(0 => '0', 1 => '1'))),
    ));

    $this->widgetSchema->setNameFormat('ohrm_language_label_string[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OhrmLanguageLabelString';
  }

}
