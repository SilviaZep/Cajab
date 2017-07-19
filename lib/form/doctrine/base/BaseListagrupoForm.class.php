<?php

/**
 * Listagrupo form base class.
 *
 * @method Listagrupo getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseListagrupoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idgrupo'        => new sfWidgetFormInputHidden(),
      'nombre'         => new sfWidgetFormInputText(),
      'grado'          => new sfWidgetFormInputText(),
      'ciclo'          => new sfWidgetFormInputText(),
      'profesor'       => new sfWidgetFormInputText(),
      'seccion'        => new sfWidgetFormInputText(),
      'idgrado'        => new sfWidgetFormInputText(),
      'idcuenta'       => new sfWidgetFormInputText(),
      'idcicloescolar' => new sfWidgetFormInputText(),
      'idseccion'      => new sfWidgetFormInputText(),
      'oficial'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idgrupo'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idgrupo')), 'empty_value' => $this->getObject()->get('idgrupo'), 'required' => false)),
      'nombre'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'grado'          => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'ciclo'          => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'profesor'       => new sfValidatorString(array('max_length' => 252, 'required' => false)),
      'seccion'        => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'idgrado'        => new sfValidatorInteger(array('required' => false)),
      'idcuenta'       => new sfValidatorInteger(array('required' => false)),
      'idcicloescolar' => new sfValidatorInteger(array('required' => false)),
      'idseccion'      => new sfValidatorInteger(array('required' => false)),
      'oficial'        => new sfValidatorString(array('max_length' => 1, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('listagrupo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Listagrupo';
  }

}
