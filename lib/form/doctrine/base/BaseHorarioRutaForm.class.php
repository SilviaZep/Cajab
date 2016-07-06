<?php

/**
 * HorarioRuta form base class.
 *
 * @method HorarioRuta getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseHorarioRutaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'r_lun_e'          => new sfWidgetFormInputText(),
      'r_lun_s'          => new sfWidgetFormInputText(),
      'r_mar_e'          => new sfWidgetFormInputText(),
      'r_mar_s'          => new sfWidgetFormInputText(),
      'r_mie_e'          => new sfWidgetFormInputText(),
      'r_mie_s'          => new sfWidgetFormInputText(),
      'r_jue_e'          => new sfWidgetFormInputText(),
      'r_jue_s'          => new sfWidgetFormInputText(),
      'r_vie_e'          => new sfWidgetFormInputText(),
      'r_vie_s'          => new sfWidgetFormInputText(),
      'fecha_registro'   => new sfWidgetFormDateTime(),
      'usuario_registro' => new sfWidgetFormInputText(),
      'tipo'             => new sfWidgetFormInputText(),
      'id_alumno'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'r_lun_e'          => new sfValidatorInteger(array('required' => false)),
      'r_lun_s'          => new sfValidatorInteger(array('required' => false)),
      'r_mar_e'          => new sfValidatorInteger(array('required' => false)),
      'r_mar_s'          => new sfValidatorInteger(array('required' => false)),
      'r_mie_e'          => new sfValidatorInteger(array('required' => false)),
      'r_mie_s'          => new sfValidatorInteger(array('required' => false)),
      'r_jue_e'          => new sfValidatorInteger(array('required' => false)),
      'r_jue_s'          => new sfValidatorInteger(array('required' => false)),
      'r_vie_e'          => new sfValidatorInteger(array('required' => false)),
      'r_vie_s'          => new sfValidatorInteger(array('required' => false)),
      'fecha_registro'   => new sfValidatorDateTime(array('required' => false)),
      'usuario_registro' => new sfValidatorInteger(array('required' => false)),
      'tipo'             => new sfValidatorInteger(array('required' => false)),
      'id_alumno'        => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('horario_ruta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'HorarioRuta';
  }

}
