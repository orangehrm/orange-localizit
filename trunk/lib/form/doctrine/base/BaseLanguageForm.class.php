<?php

/**
 * Language form base class.
 *
 * @method Language getObject() Returns the current form's model object
 *
 * @package    localizit
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLanguageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'language_id'     => new sfWidgetFormInputHidden(),
      'language_code'   => new sfWidgetFormInputText(),
      'language_name'   => new sfWidgetFormInputText(),
      'language_status' => new sfWidgetFormChoice(array('choices' => array(0 => '0', 1 => '1'))),
    ));

    $this->setValidators(array(
      'language_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('language_id')), 'empty_value' => $this->getObject()->get('language_id'), 'required' => false)),
      'language_code'   => new sfValidatorString(array('max_length' => 10)),
      'language_name'   => new sfValidatorString(array('max_length' => 45)),
      'language_status' => new sfValidatorChoice(array('choices' => array(0 => '0', 1 => '1'))),
    ));

    $this->widgetSchema->setNameFormat('language[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Language';
  }

}
