<?php

/**
 * Label form base class.
 *
 * @method Label getObject() Returns the current form's model object
 *
 * @package    localizit
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLabelForm extends BaseFormDoctrine
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
      'label_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('label_id')), 'empty_value' => $this->getObject()->get('label_id'), 'required' => false)),
      'label_name'    => new sfValidatorString(array('max_length' => 45)),
      'label_comment' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'label_status'  => new sfValidatorChoice(array('choices' => array(0 => '0', 1 => '1'))),
    ));

    $this->widgetSchema->setNameFormat('label[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Label';
  }

}
