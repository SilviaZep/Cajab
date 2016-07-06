<?php
/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfValidatorUser.class.php,v 1.4 2009/07/20 16:23:28 
 */
class sfValidatorUser extends sfValidatorBase
{
  protected $messages = array('no_credentials'=>'no_credentials',
                              'no_habilitado'=>'no_habilitado');

  public function configure($options = array(), $messages = array())
  {
    $this->addOption('usuario', 'usuario');
    $this->addOption('password', 'password');   
    $this->addOption('throw_global_error', true);

    $this->setMessage('invalid', 'El usuario y/o la contrase&ntilde;a no son v&aacute;lidos.');
    $this->setMessage('no_habilitado', 'El usuario y la contrase&ntilde;a son correctos, pero el administrador del sistema no lo ha habilitado para ingresar.');
    $this->setMessage('no_credentials', 'El usuario y la contrase&ntilde;a son correctos, pero no tiene los permisos correspondientes para ingresar a esta aplicaci&oacute;n.');
  }

  protected function doClean($values)
  {
 
    $username = isset($values[$this->getOption('usuario')]) ? $values[$this->getOption('usuario')] : '';
    $password = isset($values[$this->getOption('password')]) ? $values[$this->getOption('password')] : '';  
    

    //se obtiene el usuario por nombre de usuario
    $user = Doctrine::getTable('Usuario')->getUsuarioBy($username);
    
    if (is_object($user) && $user->getId() > 0)
    {
      // password is ok?
      if ($user->isPasswordValid($password))
      {
        //se verifica si el usuario esta activo
        if(!$user->isActive())
        {
            throw new sfValidatorError($this, 'no_habilitado');
        }
      	
        return array_merge($values, array('user' => $user));
      }
    }

    throw new sfValidatorError($this, 'invalid');
  }
}
