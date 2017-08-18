<?php

/**
 * Ruta form base class.
 *
 * @method Ruta getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRutaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'capacidad'   => new sfWidgetFormInputText(),
      'chofer'      => new sfWidgetFormInputText(),
      'nombre'      => new sfWidgetFormInputText(),
      'descripcion' => new sfWidgetFormInputText(),
      'horario'     => new sfWidgetFormInputText(),
      'estatus'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'capacidad'   => new sfValidatorInteger(array('required' => false)),
      'chofer'      => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'nombre'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'descripcion' => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'horario'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'estatus'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ruta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ruta';
  }

}
