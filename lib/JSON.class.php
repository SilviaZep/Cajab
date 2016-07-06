<?php

class JSON
{
    static function json_encode($input = false)
    {
        if (is_null($input)) 
            return 'null';
        if ($input === false) 
            return 'false';
        if ($input === true) 
            return 'true';
            
        if (is_scalar($input))
        {
          if (is_float($input))
          {
            // Always use "." for floats.
            return floatval(str_replace(",", ".", strval($input)));
          }

          if (is_string($input))
          {
            static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
            return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $input) . '"';
          }
          else
            return '"'.$input.'"';
        }

        $isList = true;
        for ($i = 0, reset($input); $i < count($input); $i++, next($input))
        {
          if (key($input) !== $i)
          {
            $isList = false;
            break;
          }
        }

        $result = array();
        if ($isList)
        {
            foreach ($input as $v) $result[] = self::json_encode($v);
            return '[' . join(',', $result) . ']';
        }
        else
        {
            foreach ($input as $k => $v) $result[] = self::json_encode($k).':'.self::json_encode($v);
            return '{' . join(',', $result) . '}';
        }
    }
    
    static function json_decode($input = "")
    {
        throw new Exception("Method no implemented yet.");
    }
}