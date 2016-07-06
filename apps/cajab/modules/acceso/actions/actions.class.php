<?php

/**
 * acceso actions.
 *
 * @package    puntoveta
 * @subpackage acceso
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class accesoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      //echo "hola"; die();
     $this->setLayout('login');
    if ($this->getUser()->isAuthenticated())
    {
      //envia al usuario a su pagina principal
      return $this->redirect('@homepage');//homepage del routing.yml
    }
    
    //se crea el formulario para autentificar alumnos
    $this->form = new SigninForm();
    //$this->form->setTipoUsuario(UsuarioTable::$CUENTA_DOCENTE);
    
    //se procesa el formulario al enviarse
    if ($request->isMethod(sfWebRequest::POST))
    {
      $this->form->bind($request->getParameter('signin'));
      
      if ($this->form->isValid())
      {
        $user = $this->form->getValue('user');               
        $this->getUser()->signin($user);
        
        return $this->redirect('@homepage');
      }
    }
    else
    {
      //no se permiten peticiones Ajax
      if ($request->isXmlHttpRequest())
      {
        $this->getResponse()->setHeaderOnly(true);
        $this->getResponse()->setStatusCode(401);

        return sfView::NONE;
      }

      // if we have been forwarded, then the referer is the current URL
      // if not, this is the referer of the current request
      $this->getUser()->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

      $module = sfConfig::get('sf_login_module');
      if ($this->getModuleName() != $module)
      {
        return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
      }

      $this->getResponse()->setStatusCode(401);
    }
  }
  public function executeSignout(sfWebRequest $request)
  {

   $this->getUser()->signOut();    

    return $this->redirect('@homepage');
  } 
}
