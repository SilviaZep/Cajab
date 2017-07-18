<?php

/**
 * ListaAlumnoB form base class.
 *
 * @method ListaAumnoBForm getObject() Returns the current form's model object
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
      'id'           => new sfWidgetFormInputHidden(),
      'id_alumno'    => new sfWidgetFormInputText(),
      'id_ruta'      => new sfWidgetFormInputText(),
      'fecha_inicio' => new sfWidgetFormDateTime(),
      'fecha_fin'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(    
	  'idcolonia' => new sfValidatorInteger(array('required' => false)),
	  'nombre' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'appat'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'apmat'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'cuentaactiva' => new sfValidatorString(array('max_length' => 200, 'required' => false)), 
	  'rfc'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'curp'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'direccion' => new sfValidatorString(array('max_length' => 200, 'required' => false)), 
	  'celular'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'telefono' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'email'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'idalumno' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
	  'idcicloescolar' => new sfValidatorInteger(array('required' => false)),
	  'idgrado' => new sfValidatorInteger(array('required' => false)),
	  'idgrupo' => new sfValidatorInteger(array('required' => false)),
	  'matricula'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'fechaingreso'  => new sfValidatorDateTime(array('required' => false)),
	  'alumnoactivo'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'motivoseparacion' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'fechabaja'  => new sfValidatorDateTime(array('required' => false)),
	  'fechanacimiento' => new sfValidatorDateTime(array('required' => false)),
	  'sexo'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'escuelaprocedencia'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'usuarioactivo'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'nombrecompleto' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'NombreCicloEscolar' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'NombreGrado'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'NombreGrupo'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'NombreSeccion' => new sfValidatorString(array('max_length' => 200, 'required' => false)), 
	  'GradoPuro'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'idseccion' => new sfValidatorInteger(array('required' => false)),
	  'seccion'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'grado'  => new sfValidatorString(array('max_length' => 200, 'required' => false)),
	  'TipoSeccion'  => new sfValidatorString(array('max_length' => 200, 'required' => false))    		
    ));

    $this->widgetSchema->setNameFormat('listaalumnob[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListaAlumnoB';
  }

}
