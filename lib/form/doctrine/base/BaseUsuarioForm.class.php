<?php

/**
 * Usuario form base class.
 *
 * @method Usuario getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUsuarioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'nombre_completo' => new sfWidgetFormInputText(),
      'usuario'         => new sfWidgetFormInputText(),
      'password'        => new sfWidgetFormInputText(),
      'rol'             => new sfWidgetFormInputText(),
      'estatus'         => new sfWidgetFormInputText(),
      'fecha_creacion'  => new sfWidgetFormDateTime(),
      'id_empleado'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre_completo' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'usuario'         => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'password'        => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'rol'             => new sfValidatorInteger(array('required' => false)),
      'estatus'         => new sfValidatorInteger(array('required' => false)),
      'fecha_creacion'  => new sfValidatorDateTime(array('required' => false)),
      'id_empleado'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('usuario[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Usuario';
  }

}
