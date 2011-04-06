<?php

/**
 * LanguageLabelString form base class.
 *
 * @method LanguageLabelString getObject() Returns the current form's model object
 *
 * @package    localizit
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLanguageLabelStringForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'language_label_string_id'     => new sfWidgetFormInputHidden(),
      'label_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Label'), 'add_empty' => false)),
      'language_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Language'), 'add_empty' => false)),
      'language_label_string'        => new sfWidgetFormInputText(),
      'language_label_string_status' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'language_label_string_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('language_label_string_id')), 'empty_value' => $this->getObject()->get('language_label_string_id'), 'required' => false)),
      'label_id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Label'))),
      'language_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Language'))),
      'language_label_string'        => new sfValidatorString(array('max_length' => 45)),
      'language_label_string_status' => new sfValidatorString(array('max_length' => 1)),
    ));

    $this->widgetSchema->setNameFormat('language_label_string[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LanguageLabelString';
  }

}
