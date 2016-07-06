<?php

/**
 * Egresos form base class.
 *
 * @method Egresos getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEgresosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'id_servicio'    => new sfWidgetFormInputText(),
      'id_proveedor'   => new sfWidgetFormInputText(),
      'id_concepto'    => new sfWidgetFormInputText(),
      'fecha_registro' => new sfWidgetFormDate(),
      'cantidad'       => new sfWidgetFormInputText(),
      'observaciones'  => new sfWidgetFormTextarea(),
      'estatus'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'id_servicio'    => new sfValidatorInteger(array('required' => false)),
      'id_proveedor'   => new sfValidatorInteger(array('required' => false)),
      'id_concepto'    => new sfValidatorInteger(array('required' => false)),
      'fecha_registro' => new sfValidatorDate(array('required' => false)),
      'cantidad'       => new sfValidatorNumber(array('required' => false)),
      'observaciones'  => new sfValidatorString(array('required' => false)),
      'estatus'        => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('egresos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Egresos';
  }

}
