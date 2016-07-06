<?php

class UTF
{
  static function UTFDecode($values)
  {
    $decodedvalues = array();
    if(is_array($values) && count(is_array($values) > 0))
    {
      foreach($values as $key => $val)
      {
        if(is_string($val)){
          $decodedvalues[$key] = utf8_decode($val);
        }else
        {
          $decodedvalues[$key] = $val;
        }
      }
    }else
    {
       $decodedvalues = utf8_decode($values);
    }

    return $decodedvalues;
  }
}