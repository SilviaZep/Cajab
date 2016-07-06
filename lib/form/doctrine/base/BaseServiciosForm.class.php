<?php

/**
 * Servicios form base class.
 *
 * @method Servicios getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseServiciosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'id_servicio'        => new sfWidgetFormInputText(),
      'nombre'             => new sfWidgetFormInputText(),
      'aplica_parcialidad' => new sfWidgetFormInputText(),
      'precio'             => new sfWidgetFormInputText(),
      'pago_obligatorio'   => new sfWidgetFormInputText(),
      'fecha_evento'       => new sfWidgetFormDate(),
      'capacidad'          => new sfWidgetFormInputText(),
      'fecha_inicio'       => new sfWidgetFormDateTime(),
      'fecha_fin'          => new sfWidgetFormDateTime(),
      'usuario_aplica'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'id_servicio'        => new sfValidatorInteger(array('required' => false)),
      'nombre'             => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'aplica_parcialidad' => new sfValidatorInteger(array('required' => false)),
      'precio'             => new sfValidatorNumber(array('required' => false)),
      'pago_obligatorio'   => new sfValidatorInteger(array('required' => false)),
      'fecha_evento'       => new sfValidatorDate(array('required' => false)),
      'capacidad'          => new sfValidatorInteger(array('required' => false)),
      'fecha_inicio'       => new sfValidatorDateTime(array('required' => false)),
      'fecha_fin'          => new sfValidatorDateTime(array('required' => false)),
      'usuario_aplica'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('servicios[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Servicios';
  }

}
