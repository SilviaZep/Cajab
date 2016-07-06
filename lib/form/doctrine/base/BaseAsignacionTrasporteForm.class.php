<?php

/**
 * AsignacionTrasporte form base class.
 *
 * @method AsignacionTrasporte getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAsignacionTrasporteForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'id_alumno'    => new sfWidgetFormInputText(),
      'id_ruta'      => new sfWidgetFormInputText(),
      'fecha_inicio' => new sfWidgetFormDateTime(),
      'fecha_fin'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'id_alumno'    => new sfValidatorInteger(array('required' => false)),
      'id_ruta'      => new sfValidatorInteger(array('required' => false)),
      'fecha_inicio' => new sfValidatorDateTime(array('required' => false)),
      'fecha_fin'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('asignacion_trasporte[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsignacionTrasporte';
  }

}
