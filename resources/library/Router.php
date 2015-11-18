<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Router
 *
 * @author idar
 */

class Router {
    
    public $params = array();
    
    
    public function getParams() {
        return $this->params;
    }

    public function setParams($params) {
        $this->params = $params;
    }
    
    public function addParam($key,$value){
        
        $this->params[$key] = $value;
        
    }

}

?>
