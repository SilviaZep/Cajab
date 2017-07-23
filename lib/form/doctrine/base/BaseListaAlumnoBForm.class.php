<?php

/**
 * ListaAlumnoB form base class.
 *
 * @method ListaAlumnoB getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseListaAlumnoBForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'idcolonia'          => new sfWidgetFormInputText(),
      'nombre'             => new sfWidgetFormInputText(),
      'appat'              => new sfWidgetFormInputText(),
      'apmat'              => new sfWidgetFormInputText(),
      'cuentaactiva'       => new sfWidgetFormInputText(),
      'rfc'                => new sfWidgetFormInputText(),
      'curp'               => new sfWidgetFormInputText(),
      'direccion'          => new sfWidgetFormInputText(),
      'celular'            => new sfWidgetFormInputText(),
      'telefono'           => new sfWidgetFormInputText(),
      'email'              => new sfWidgetFormInputText(),
      'idalumno'           => new sfWidgetFormInputHidden(),
      'idcicloescolar'     => new sfWidgetFormInputText(),
      'idgrado'            => new sfWidgetFormInputText(),
      'idgrupo'            => new sfWidgetFormInputText(),
      'matricula'          => new sfWidgetFormInputText(),
      'fechaingreso'       => new sfWidgetFormDate(),
      'alumnoactivo'       => new sfWidgetFormInputText(),
      'motivoseparacion'   => new sfWidgetFormInputText(),
      'fechabaja'          => new sfWidgetFormDate(),
      'fechanacimiento'    => new sfWidgetFormDate(),
      'sexo'               => new sfWidgetFormInputText(),
      'escuelaprocedencia' => new sfWidgetFormInputText(),
      'usuarioactivo'      => new sfWidgetFormInputText(),
      'nombrecompleto'     => new sfWidgetFormInputText(),
      'nombrecicloescolar' => new sfWidgetFormInputText(),
      'nombregrado'        => new sfWidgetFormInputText(),
      'nombregrupo'        => new sfWidgetFormInputText(),
      'nombreseccion'      => new sfWidgetFormInputText(),
      'gradopuro'          => new sfWidgetFormInputText(),
      'idseccion'          => new sfWidgetFormInputText(),
      'seccion'            => new sfWidgetFormInputText(),
      'grado'              => new sfWidgetFormInputText(),
      'tiposeccion'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idcolonia'          => new sfValidatorInteger(array('required' => false)),
      'nombre'             => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'appat'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'apmat'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'cuentaactiva'       => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'rfc'                => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'curp'               => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'direccion'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'celular'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'telefono'           => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'email'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'idalumno'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('idalumno')), 'empty_value' => $this->getObject()->get('idalumno'), 'required' => false)),
      'idcicloescolar'     => new sfValidatorInteger(array('required' => false)),
      'idgrado'            => new sfValidatorInteger(array('required' => false)),
      'idgrupo'            => new sfValidatorInteger(array('required' => false)),
      'matricula'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fechaingreso'       => new sfValidatorDate(array('required' => false)),
      'alumnoactivo'       => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'motivoseparacion'   => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'fechabaja'          => new sfValidatorDate(array('required' => false)),
      'fechanacimiento'    => new sfValidatorDate(array('required' => false)),
      'sexo'               => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'escuelaprocedencia' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'usuarioactivo'      => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'nombrecompleto'     => new sfValidatorString(array('max_length' => 252, 'required' => false)),
      'nombrecicloescolar' => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'nombregrado'        => new sfValidatorString(array('max_length' => 96, 'required' => false)),
      'nombregrupo'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'nombreseccion'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'gradopuro'          => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'idseccion'          => new sfValidatorInteger(array('required' => false)),
      'seccion'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'grado'              => new sfValidatorString(array('max_length' => 45, 'required' => false)),
      'tiposeccion'        => new sfValidatorString(array('max_length' => 12, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ListaAlumnoB[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaAlumnoB';
  }

}
