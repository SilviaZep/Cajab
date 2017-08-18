<?php

/**
 * ListaRuta form base class.
 *
 * @method ListaRuta getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseListaRutaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'id_alumno' => new sfWidgetFormInputText(),
      'id_ruta'   => new sfWidgetFormInputText(),
      'fecha'     => new sfWidgetFormDateTime(),
      'estatus'   => new sfWidgetFormInputText(),
      'estatus_s' => new sfWidgetFormInputText(),
      'estatus_b' => new sfWidgetFormInputText(),
      'tipo'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'id_alumno' => new sfValidatorInteger(array('required' => false)),
      'id_ruta'   => new sfValidatorInteger(array('required' => false)),
      'fecha'     => new sfValidatorDateTime(array('required' => false)),
      'estatus'   => new sfValidatorInteger(array('required' => false)),
      'estatus_s' => new sfValidatorInteger(array('required' => false)),
      'estatus_b' => new sfValidatorInteger(array('required' => false)),
      'tipo'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lista_ruta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaRuta';
  }

}
