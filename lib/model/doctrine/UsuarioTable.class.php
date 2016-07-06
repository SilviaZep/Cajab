<?php

/**
 * UsuarioTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class UsuarioTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object UsuarioTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Usuario');
    }
    public function getUsuarioBy($usuario)

  {

      $q = $this->createQuery('u')

       ->whereIn('u.usuario', $usuario) ;

      return $q->fetchOne();

  }
    public function getUsuario($id)

  {

    $q = $this->createQuery('p')

    ->where("p.id=? AND p.estatus=? ", array($id, 1));

    return $q->fetchOne();

  }
}