<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    localizit
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'      => new sfWidgetFormInputHidden(),
      'login_name'   => new sfWidgetFormInputText(),
      'password'     => new sfWidgetFormInputPassword(),
      'user_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserType'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'user_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('user_id')), 'empty_value' => $this->getObject()->get('user_id'), 'required' => false)),
      'login_name'   => new sfValidatorString(array('max_length' => 25)),
      'password'     => new sfValidatorString(array('max_length' => 25)),
      'user_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserType'))),
    ));

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

}
