<?php

/**
 * Pagos form base class.
 *
 * @method Pagos getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePagosForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'id_servicio' => new sfWidgetFormInputText(),
      'id_cliente'  => new sfWidgetFormInputText(),
      'abono'       => new sfWidgetFormInputText(),
      'fecha_pago'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'id_servicio' => new sfValidatorInteger(array('required' => false)),
      'id_cliente'  => new sfValidatorInteger(array('required' => false)),
      'abono'       => new sfValidatorNumber(array('required' => false)),
      'fecha_pago'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pagos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pagos';
  }

}
