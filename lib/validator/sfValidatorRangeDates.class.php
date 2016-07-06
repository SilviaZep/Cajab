<?php

/**
 * Valida un rango de fechas
 */
class sfValidatorRangeDate extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
	//
   $this->addOption('fecha_inicio', 'fecha_inicio');
   $this->addOption('fecha_termino', 'fecha_termino');
    $this->addOption('throw_global_error', true);

    $this->setMessage('invalid', 'La Fecha de inicio "%fecha_inicio%" debe ser menor que la Fecha de termino "%fecha_termino%"');
  }

  protected function doClean($values)
  {
	
  if((!isset($values[$this->getOption('fecha_inicio')]) || empty($values[$this->getOption('fecha_inicio')]))
    && (!isset($values[$this->getOption('fecha_termino')]) || empty($values[$this->getOption('fecha_termino')])))
  {
    return $values;
  }
  
	$culture = sfContext::getInstance()->getUser()->getCulture();
	$dateFormat = new sfDateFormat($culture);
	$pattern = $dateFormat->getInputPattern("d");

    $fecha_inicio = $dateFormat->format($values[$this->getOption('fecha_inicio')],'i' ,$pattern);
    $fecha_termino = $dateFormat->format($values[$this->getOption('fecha_termino')],'i' ,$pattern);
    
    $values[$this->getOption('fecha_inicio')] = $fecha_inicio;
    $values[$this->getOption('fecha_termino')] = $fecha_termino;

	//se validan las fechas ya sin formato 'YYYY-mm-dd'
	if(strtotime($fecha_termino) >= strtotime($fecha_inicio))
	{
		return $values; 
	}

    if ($this->getOption('throw_global_error'))
    {
      throw new sfValidatorError($this, 'invalid');
    }
  }
}
