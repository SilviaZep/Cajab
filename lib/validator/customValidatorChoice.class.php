<?php

class customValidatorChoice extends sfValidatorBase
{
  /**
   * Configures the current validator.
   *
   * Available options:
   *
   *  * multiple: true if the select tag must allow multiple selections
   *  * min:      The minimum number of values that need to be selected (this option is only active if multiple is true)
   *  * max:      The maximum number of values that need to be selected (this option is only active if multiple is true)
   *
   * @param array $options    An array of options
   * @param array $messages   An array of error messages
   *
   * @see sfValidatorBase
   */
  protected function configure($options = array(), $messages = array())
  {
    $this->addOption('multiple', false);
    $this->addOption('min');
    $this->addOption('max');

    $this->addMessage('min', 'At least %min% values must be selected (%count% values selected).');
    $this->addMessage('max', 'At most %max% values must be selected (%count% values selected).');
  }

  /**
   * @see sfValidatorBase
   */
  protected function doClean($value)
  {
    return $value;
  }
}
