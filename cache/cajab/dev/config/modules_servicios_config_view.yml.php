<?php
// auto-generated by sfViewConfigHandler
// date: 2016/07/02 23:11:56
$response = $this->context->getResponse();

if ($this->actionName.$this->viewName == 'serviciosSuccess')
{
  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());
}
else if ($this->actionName.$this->viewName == 'asignarServiciosSuccess')
{
  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());
}
else
{
  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());
}

if ($templateName.$this->viewName == 'serviciosSuccess')
{
  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'menu' ? false : 'menu'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);
  $response->addMeta('title', 'Intituto Oriente CajaB', false, false);
  $response->addMeta('language', 'es', false, false);

  $response->addStylesheet('main.css', '', array ());
  $response->addStylesheet('mt_datatable.css', '', array ());
  $response->addStylesheet('menu.css', '', array ());
  $response->addStylesheet('bootstrap.min.css', '', array ());
  $response->addStylesheet('jquery.dataTables.min.css', '', array ());
  $response->addJavascript('jquery1-12-0.min.js', '', array ());
  $response->addJavascript('bootstrap.min.js', '', array ());
  $response->addJavascript('jquery.dataTables.min.js', '', array ());
  $response->addJavascript('moment.min.js', '', array ());
  $response->addJavascript('servicios.js', '', array ());
}
else if ($templateName.$this->viewName == 'asignarServiciosSuccess')
{
  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'menu' ? false : 'menu'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);
  $response->addMeta('title', 'Intituto Oriente CajaB', false, false);
  $response->addMeta('language', 'es', false, false);

  $response->addStylesheet('main.css', '', array ());
  $response->addStylesheet('mt_datatable.css', '', array ());
  $response->addStylesheet('menu.css', '', array ());
  $response->addStylesheet('bootstrap.min.css', '', array ());
  $response->addStylesheet('jquery.dataTables.min.css', '', array ());
  $response->addJavascript('jquery1-12-0.min.js', '', array ());
  $response->addJavascript('bootstrap.min.js', '', array ());
  $response->addJavascript('jquery.dataTables.min.js', '', array ());
  $response->addJavascript('moment.min.js', '', array ());
  $response->addJavascript('asignarServicios.js', '', array ());
}
else
{
  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'menu' ? false : 'menu'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);
  $response->addMeta('title', 'Intituto Oriente CajaB', false, false);
  $response->addMeta('language', 'es', false, false);

  $response->addStylesheet('main.css', '', array ());
  $response->addStylesheet('mt_datatable.css', '', array ());
  $response->addStylesheet('menu.css', '', array ());
  $response->addStylesheet('bootstrap.min.css', '', array ());
  $response->addStylesheet('jquery.dataTables.min.css', '', array ());
  $response->addJavascript('jquery1-12-0.min.js', '', array ());
  $response->addJavascript('bootstrap.min.js', '', array ());
  $response->addJavascript('jquery.dataTables.min.js', '', array ());
}

