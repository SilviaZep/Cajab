<?php

/**
 * ServiciosCliente form base class.
 *
 * @method ServiciosCliente getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseServiciosClienteForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'id_servicio'      => new sfWidgetFormInputText(),
      'id_alumno'        => new sfWidgetFormInputText(),
      'id_cliente'       => new sfWidgetFormInputText(),
      'fecha_registro'   => new sfWidgetFormDateTime(),
      'usuario_registro' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'id_servicio'      => new sfValidatorInteger(array('required' => false)),
      'id_alumno'        => new sfValidatorInteger(array('required' => false)),
      'id_cliente'       => new sfValidatorInteger(array('required' => false)),
      'fecha_registro'   => new sfValidatorDateTime(array('required' => false)),
      'usuario_registro' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('servicios_cliente[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ServiciosCliente';
  }

}
