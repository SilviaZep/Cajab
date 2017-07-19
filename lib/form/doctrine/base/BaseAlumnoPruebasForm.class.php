<?php

/**
 * AlumnoPruebas form base class.
 *
 * @method AlumnoPruebas getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAlumnoPruebasForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'     => new sfWidgetFormInputHidden(),
      'nombre' => new sfWidgetFormInputText(),
      'grado'  => new sfWidgetFormInputText(),
      'grupo'  => new sfWidgetFormInputText(),
      'ciclo'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'grado'  => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'grupo'  => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'ciclo'  => new sfValidatorString(array('max_length' => 45, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('alumno_pruebas[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AlumnoPruebas';
  }

}
