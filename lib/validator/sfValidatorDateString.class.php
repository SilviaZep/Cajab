<?php

/**
 * sfCustomValidatorDate provides custom date validation for strings
 *
 */
class sfValidatorDateString extends sfValidatorBase
{
  /**
   * Configures the current validator.
   *
   * Available options:
   *
   *  * date_pattern:            The formar that date must be
   *  * with_time:               true if the validator must return a time, false otherwise
   *  * date_output:             The format to use when returning a date (default to Y-m-d)
   *  * datetime_output:         The format to use when returning a date with time (default to Y-m-d H:i:s)
   *  * date_format_error:       The date format to use when displaying an error for a bad_format error (use date_format if not provided)
   *  * max:                     The maximum date allowed (as a timestamp or accecpted date() format)
   *  * min:                     The minimum date allowed (as a timestamp or accecpted date() format)
   *  * date_format_range_error: The date format to use when displaying an error for min/max (default to d/m/Y H:i:s)
   *
   * Available error codes:
   *
   *  * bad_format
   *  * min
   *  * max
   *
   * @param array $options    An array of options
   * @param array $messages   An array of error messages
   *
   * @see sfValidatorBase
   */
  protected function configure($options = array(), $messages = array())
  {
    $dateFormat = new sfDateFormat(sfContext::getInstance()->getUser()->getCulture());
    $pattern = $dateFormat->getInputPattern("d");
      
    $this->addMessage('bad_format', '"%value%" no tiene el formato correcto (%date_format%).');
    $this->addMessage('max', 'La fecha debe ser antes de %max%.');
    $this->addMessage('min', 'La fecha debe ser despu&eacute;s de %min%.');

    $this->addOption('date_pattern', null);
    $this->addOption('date_format_input', $pattern); //'dd-MM-yyyy'
    $this->addOption('date_format_output', 'yyyy-MM-dd');
    $this->addOption('with_time', false);
    $this->addOption('date_output', 'Y-m-d');
    $this->addOption('datetime_output', 'Y-m-d H:i:s');
    $this->addOption('date_format_error');
    $this->addOption('min', null);
    $this->addOption('max', null);
    $this->addOption('date_format_range_error', 'd/m/Y H:i:s');
  }

  protected function validatePattern($date_str, $strPattern)
  {
    // an array of the valide date characters, see: http://php.net/date#AEN21898
    $arrCharacters = array(
        'd', // day
        'm', // month
        'M', // month
        'y', // year, 2 digits
        'Y', // year, 4 digits
        'H', // hours
        'i', // minutes
        's'  // seconds
    );

	// transform the characters array to a string
    $strCharacters = implode('', $arrCharacters);
	// splits up the pattern by the date characters to get an array of the delimiters between the date characters
    $arrDelimiters = preg_split('%['.$strCharacters.']%', $strPattern);
	// transform the delimiters array to a string
    $strDelimiters = quotemeta(implode('', array_unique($arrDelimiters)));
	// splits up the date by the delimiters to get an array of the declaration
    $arrStr     = preg_split('~['.$strDelimiters.']~', $date_str);
    // splits up the pattern by the delimiters to get an array of the used characters
    $arrPattern = preg_split('~['.$strDelimiters.']~', $strPattern);

    // if the numbers of the two array are not the same, return false, because the cannot belong together
    if (count($arrStr) !== count($arrPattern)) {
        return false;
    }

	return true;
  }
  /**
   * @see sfValidatorBase
   */
  protected function doClean($value) {
    // check date format
    if (is_string($value) && $pattern = $this->getOption('date_pattern'))
    {
      if (!$this->validatePattern($value, $pattern))
      {
        throw new sfValidatorError($this, 'bad_format', array('value' => $value, 'date_format' => $this->getOption('date_format_error') ? $this->getOption('date_format_error') : $this->getOption('date_format')));
      }
    }
	
	//aqui la fecha es valida en formato
    try {
        $df = new sfDateFormat();
        $value = $df->format($value, $this->getOption('date_format_output'), $this->getOption('date_format_input'));
    } catch (Exception $e) {
        throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }

    try
    {
      $date = new DateTime($value);
      $date->setTimezone(new DateTimeZone(date_default_timezone_get()));
      $clean = $date->format('YmdHis');
    }
    catch (Exception $e)
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value));
    }

    // check max
    $max = $this->getOption('max');
    if ($max)
    {
        // convert timestamp to date number format
        $dateMax  = new DateTime($max);
        $max      = $dateMax->format('YmdHis');
        $maxError = $dateMax->format($this->getOption('date_format_range_error'));
        if ($clean > $max)
        {
          throw new sfValidatorError($this, 'max', array('value' => $value, 'max' => $maxError));
        }
    }

    // check min date
    $min = $this->getOption('min');
    if ($min)
    {
      // convert timestamp to date number
      $dateMin  = new DateTime($min);
      $min      = $dateMin->format('YmdHis');
      $minError = $dateMin->format($this->getOption('date_format_range_error'));

      if ($clean < $min)
      {
        throw new sfValidatorError($this, 'min', array('value' => $value, 'min' => $minError));
      }
    }

    if ($clean === $this->getEmptyValue())
    {
      return $cleanTime;
    }

    $format = $this->getOption('with_time') ? $this->getOption('datetime_output') : $this->getOption('date_output');

    return isset($date) ? $date->format($format) : date($format, $cleanTime);
  }

  /**
   * @see sfValidatorBase
   */
  protected function isEmpty($value)
  {
    if (is_array($value))
    {
      $filtered = array_filter($value);

      return empty($filtered);
    }

    return parent::isEmpty($value);
  }
}
