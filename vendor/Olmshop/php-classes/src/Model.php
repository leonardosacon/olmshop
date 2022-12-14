<?php

namespace Olmshop;

class Model {

    private $values = [];

    public function __call($name, $args)
    {
        $method = substr($name, 0, 3);
        $filedName = substr($name, 3, strlen($name));
        

        switch($method){
            case 'get':
                $this->values[$filedName];
                break;
            case 'set':
                $this->values[$filedName] = $args[0];
                break;
        }

    }

    public function setData($data = array()){
        foreach ($data as $key => $value) {
            $this->{"set".$key}($value);
        }
    }

    public function getValues(){
        return $this->values;
    }

}