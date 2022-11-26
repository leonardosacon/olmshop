<?php

namespace Olmshop;

use Rain\Tpl;

class Page {

    private $tpl;
    private $options;
    private $defaults = [
        "data" => []
    ];

    public function __construct()
    {
        $this->options = array_merge($this->defaults);

        $config = array(
            "tpl_dir" => $_SERVER['DOCUMENT_ROOT']."/views/",
            "cache_dir" => $_SERVER['DOCUMENT_ROOT']."/views-cache",
            "debug" => true
        );

        Tpl::configure($config);
        $this->tpl = new Tpl;

        $this->setData($this->options["data"]);

        $this->tpl->draw("header");
    }

    public function setData($data = array()){
        foreach ($data as $key => $value) {
            $this->tpl->assign($key, $value);
        }
    }

    public function setTpl($name, $data=array(), $returnHTML=false){
        $this->setData($data);

        return $this->tpl->draw($name, $returnHTML);

    }

    public function __destruct()
    {
        $this->tpl->draw("footer");
    }
}