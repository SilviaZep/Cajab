<?php

class ValidatorRenewPassword extends sfValidatorBase
{
  protected $messages = array('invalid_password'=>'invalid_password');
  
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('username', 'username');
    $this->addOption('old_password', 'old_password');
    $this->addOption('new_password', 'new_password');
    $this->addOption('confirm_password', 'confirm_password');

    $this->addOption('throw_global_error', true);

    $this->setMessage('invalid', 'El usuario y/o la contrase&ntilde;a anterior no son v&aacute;lidos');
    $this->setMessage('invalid_password', 'Las contrase&ntilde;as no coinciden, escribalas nuevamente');
  }

  protected function doClean($values)
  {
    $username = isset($values[$this->getOption('username')]) ? $values[$this->getOption('username')] : '';
    $password = isset($values[$this->getOption('old_password')]) ? $values[$this->getOption('old_password')] : '';
    $newpassword = isset($values[$this->getOption('new_password')]) ? $values[$this->getOption('new_password')] : '';
    $repassword = isset($values[$this->getOption('confirm_password')]) ? $values[$this->getOption('confirm_password')] : '';

    // user exists?
    $user = Doctrine::getTable('Usuario')->findOneBy('username', $username);
    
    
    if (is_object($user) && $user->getId() > 0)
    {
      if ($user->isPasswordValid($password))
      {
      	//compara las nuevas contraseñas
      	if(strtolower($newpassword) === strtolower($repassword))
      	{
      		return array_merge($values, array('user' => $user));
      	}else{
      		throw new sfValidatorError($this, 'invalid_password');
      	}
      }
    }
    
    throw new sfValidatorError($this, 'invalid');
  }
}
