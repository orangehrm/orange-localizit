<?php

/**
 * OhrmLabel form base class.
 *
 * @method OhrmLabel getObject() Returns the current form's model object
 *
 * @package    localizit
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseOhrmLabelForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'label_id'      => new sfWidgetFormInputHidden(),
      'label_name'    => new sfWidgetFormInputText(),
      'label_comment' => new sfWidgetFormInputText(),
      'label_status'  => new sfWidgetFormChoice(array('choices' => array(0 => '0', 1 => '1'))),
    ));

    $this->setValidators(array(
      'label_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'label_id', 'required' => false)),
      'label_name'    => new sfValidatorString(array('max_length' => 45)),
      'label_comment' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'label_status'  => new sfValidatorChoice(array('choices' => array(0 => '0', 1 => '1'))),
    ));

    $this->widgetSchema->setNameFormat('ohrm_label[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OhrmLabel';
  }

}
