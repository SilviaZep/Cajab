<?php

/**
 * SigninForm for signin action
 *
 */
class SigninForm extends BaseForm
{
  /**
   * @see sfForm
   */
  public function configure()
  { 
    $this->setWidgets(array(
      'usuario' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputPassword(array('type' => 'password'))
    ));

    $this->setValidators(array(    
      'usuario' => new sfValidatorString(),
      'password' => new sfValidatorString()
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorUser());

    $this->widgetSchema->setNameFormat('signin[%s]');
    
    $this->widgetSchema->setLabels(array(
      'username'=> 'Usuario',
      'password'=> 'Contrase&ntilde;a'
    ));
  }
  
  
}
