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
abstract class BaseCronEjecutadoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'     => new sfWidgetFormInputHidden(),
      'tipo' => new sfWidgetFormInputText(),
      'fecha_ejecucion'  => new sfWidgetFormDateTime()
    ));

    $this->setValidators(array(
      'id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'tipo' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'fecha_ejecucion'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cron_ejecutado[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CronEjecutado';
  }

}
