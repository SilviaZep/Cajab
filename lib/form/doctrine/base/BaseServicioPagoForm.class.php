<?php

/**
 * ServicioPago form base class.
 *
 * @method ServicioPago getObject() Returns the current form's model object
 *
 * @package    puntoveta
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseServicioPagoForm extends BaseFormDoctrine {

    public function setup() {
        $this->setWidgets(array(
            'id' => new sfWidgetFormInputHidden(),
            'id_servicio' => new sfWidgetFormInputText(),
            'id_cliente' => new sfWidgetFormInputText(),
            'monto' => new sfWidgetFormInputText(),
            'fecha_pago' => new sfWidgetFormDateTime(),
            'tipo_cliente' => new sfWidgetFormInputText(),
            'id_alumno' => new sfWidgetFormInputText(),
            'usuario_registro' => new sfWidgetFormInputText(),
            'fecha_registro' => new sfWidgetFormDateTime(),
            'tipo_pago' => new sfWidgetFormInputText(),
            'forma_pago' => new sfWidgetFormInputText(),
            'id_pago' => new sfWidgetFormInputText(),
             'descuento' => new sfWidgetFormInputText(),
			   'estatus' => new sfWidgetFormInputText(),
        ));

        $this->setValidators(array(
            'id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
            'id_servicio' => new sfValidatorInteger(array('required' => false)),
            'id_cliente' => new sfValidatorInteger(array('required' => false)),
            'monto' => new sfValidatorNumber(array('required' => false)),
            'fecha_pago' => new sfValidatorDateTime(array('required' => false)),
            'tipo_cliente' => new sfValidatorInteger(array('required' => false)),
            'id_alumno' => new sfValidatorInteger(array('required' => false)),
            'usuario_registro' => new sfValidatorInteger(array('required' => false)),
            'fecha_registro' => new sfValidatorDateTime(array('required' => false)),
            'tipo_pago' => new sfValidatorInteger(array('required' => false)),
            'forma_pago' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
            'id_pago' => new sfValidatorInteger(array('required' => false)),
             'descuento' => new sfValidatorNumber(array('required' => false)),
			  'estatus' => new sfValidatorNumber(array('required' => false)),
        ));

        $this->widgetSchema->setNameFormat('servicio_pago[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

        $this->setupInheritance();

        parent::setup();
    }

    public function getModelName() {
        return 'ServicioPago';
    }

}
