<?php

/**
 * CategoriaServicio form base class.
 *
 * @method CategoriaServicio getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoriaServicioForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'categoria'   => new sfWidgetFormInputText(),
      'estatus'     => new sfWidgetFormInputText(),
      'tipo'        => new sfWidgetFormInputText(),
      'descripcion' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'categoria'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'estatus'     => new sfValidatorInteger(array('required' => false)),
      'tipo'        => new sfValidatorInteger(array('required' => false)),
      'descripcion' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('categoria_servicio[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoriaServicio';
  }

}
