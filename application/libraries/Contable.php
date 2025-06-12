<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contable {

    public $id;
    public $valor;

    public function __construct($id=0,$valor="") {
        $this->id=$id;
        $this->valor=$valor;
    }

}
