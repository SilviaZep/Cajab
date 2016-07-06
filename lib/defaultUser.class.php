<?php

class defaultUser extends sfBasicSecurityUser
{
  //referencia a la Tabla Usuario
  protected $user = null;
  
  public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
  {
    parent::initialize($dispatcher, $storage, $options);

    if (false === $this->isAuthenticated())
    {
      $this->_resetUserSession();
    }
  }
  
  /**
   * Returns the related DBUser.
   *
   * @return User
   */
  public function getDBUser()
  {
    $id = $this->getAttribute('id', null);
    
    if (!$this->user && $id)
    {
      $this->user = Doctrine::getTable('Usuario')->find($id);

      if (!$this->user)
      {
        // the user does not exist anymore in the database
        $this->_resetUserSession();

        throw new sfException('El usuario ha sido eliminado de la base de datos.');
      }
    }

    return $this->user;
  }
  
  /**
   * defaultUser::signIn()
   *
   * @param Usuario $user
   * @param bool $remember
   * @param mixed $con
   * @return void
   */
  public function signIn($user)
  {
    $this->user = $user;
    //se ponen los valores en la sesion del usuario
    $this->setAttribute('id', $this->user->getId());
    $this->setAttribute('nombre_completo', $this->user->getNombreCompleto()); 
    $this->setAttribute('rol', $this->user->getRol()); 
    $this->setAttribute('id_empleado', $this->user->getIdEmpleado()); 
   
  
   // $this->_registraEntrada($user->getId());
    
    //se inicia la bandera de la sesion
    $this->setAuthenticated(true);
  }

  /**
   * sfControlEscolarSecurityUser::signOut()
   *
   * Termina la sesion de un usuario
   * @return void
   */
  public function signOut()
  {
    $user = $this->getDBUser();
    if($user)
    {
     // $this->_registraSalida($user->getId());
      $this->_resetUserSession();
    }
  }
  
  public function getUsername()
  {
    return $this->getAttribute('usuario');
  }

  
  
  public function getEmail()
  {
    return $this->getUser()->getCorreoElectronico();
  }
  
  public function setUsername($username)
  {
    $this->setAttribute('usuario', $username);
  }
  
  public function getReferer($default ="")
  {
    $referer = $this->getAttribute('referer', $default);

    return $referer ? $referer : $default;
  }

  public function setReferer($referer)
  {
    $this->setAttribute('referer', $referer);
  }

  public function getUserId()
  {
     return $this->getAttribute('id');
  }
  
  public function getNombreCompleto()
  {
    return $this->getAttribute('nombre_completo');
  }
  public function getRol()
  {
    return $this->getAttribute('rol');
  }
   public function getEmpresaId()
  {
    return $this->getAttribute('empleado_id');
  }   
 

  /**
   * sfControlEscolarSecurityUser::generateRandomKey()
   * Para generar passwords aleatorios de 8 caracteres
   * @param integer $len
   * @return
   */
  public function generateRandomKey($len = 10)
  {
    $string = '';
    $pool   = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ0123456789';
    for ($i = 1; $i <= $len; $i++)
    {
      $string .= substr($pool, rand(0, 61), 1);
    }

    return $string;
  }

  /*
   *  Reinicia una contrasenia de un usuario especificado
   */
   public function resetPassword(Usuario $user)
  {
    $cuenta_activa = ((int)$user->getEstado() === UsuarioTable::$CUENTA_ACTIVA);
    
    $temp_password = $this->generateRandomKey(10);
    
    if($user && $cuenta_activa)
    {
      $user->setExpira(date('Y-m-d h:m:s'));
      $user->setPassword(md5($temp_password));
      $user->incrementaReinicios();
      $user->setUpdatedAt(date('Y-m-d h:m:s'));
      
      $user->save();
    }
    
    return $temp_password;
  }

  
  private function _resetUserSession()
  {
    $this->getAttributeHolder()->removeNamespace();
    $this->user = null;
    $this->clearCredentials();
    $this->setAuthenticated(false);
  }
  
  
  
 
}