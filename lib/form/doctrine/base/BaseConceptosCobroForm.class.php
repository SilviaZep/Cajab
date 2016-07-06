<?php

/**
 * ConceptosCobro form base class.
 *
 * @method ConceptosCobro getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseConceptosCobroForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputText(),
      'id_servicio'    => new sfWidgetFormInputText(),
      'concepto'       => new sfWidgetFormInputText(),
      'fecha_registro' => new sfWidgetFormDate(),
	   'estatus' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorInteger(),
      'id_servicio'    => new sfValidatorInteger(array('required' => false)),
      'concepto'       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'fecha_registro' => new sfValidatorDate(array('required' => false)),
	  'estatus'    => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('conceptos_cobro[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ConceptosCobro';
  }

}
