<?php

class ValidatorPhone extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
  }

  protected function doClean($values)
  {
    $lada = !empty($values["lada"])? '('.$values["lada"].')' : '';
	$numero = !empty($values["number"])? $values["number"] : '';
	$tipo = !empty($values["tipo"])? '['.$values["tipo"].']' : '';

	return $lada." ".$numero." ".$tipo;
  }
}
