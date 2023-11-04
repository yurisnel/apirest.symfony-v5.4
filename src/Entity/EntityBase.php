<?php

namespace App\Entity;


abstract class EntityBase
{
      var $_classMethods;
      public function setProperties(array $options)
      {
            if (!$this->_classMethods)
                  $this->_classMethods = get_class_methods($this);
            foreach ($options as $name => $value) {
                  $method = 'set' . ucfirst($name);
                  if (in_array($method, $this->_classMethods)) {
                        $this->$method($value);
                  } else {
                        //throw new \Exception('Invalid method name');
                  }
            }
            return $this;
      }

      public function setProperty($name, $value)
      {
            return $this->setProperties(array($name, $value));
      }

      public function getProperty($name)
      {
            if (!$this->_classMethods)
                  $this->_classMethods = get_class_methods($this);
            $method = 'get' . ucfirst($name);
            if (in_array($method, $this->_classMethods)) {
                  return $this->$method();
            } else {
                  return "";
            }
      }
}
