<?php

/**
 * Listacicloescolar form base class.
 *
 * @method Listacicloescolar getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseListacicloescolarForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idcicloescolar'   => new sfWidgetFormInputHidden(),
      'fechainicio'      => new sfWidgetFormDate(),
      'fechatermino'     => new sfWidgetFormDate(),
      'estatus'          => new sfWidgetFormInputText(),
      'seccion'          => new sfWidgetFormInputText(),
      'nombre'           => new sfWidgetFormInputText(),
      'prefijomatricula' => new sfWidgetFormInputText(),
      'idseccion'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idcicloescolar'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idcicloescolar')), 'empty_value' => $this->getObject()->get('idcicloescolar'), 'required' => false)),
      'fechainicio'      => new sfValidatorDate(array('required' => false)),
      'fechatermino'     => new sfValidatorDate(array('required' => false)),
      'estatus'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'seccion'          => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'nombre'           => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'prefijomatricula' => new sfValidatorString(array('max_length' => 2, 'required' => false)),
      'idseccion'        => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('listacicloescolar[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Listacicloescolar';
  }

}
