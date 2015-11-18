<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoreController
 *
 * @author idar
 */
abstract class CoreController {
    
    public $topo , $user,  $obj, $controller,$tplFile,$lang;
    protected $params = array();
    protected $module;
    private $titles = array();
    
    function __construct($user, $controller) {
        $this->user = $user;
        $this->controller = $controller;
        $view = $this->controller->view;
        $this->module = $this->controller->module;
        $this->lang = $this->controller->lang;
        
        if(empty($view)){
            $view = "default";
        }
        
        
        if(get_class($this) == "Menu_controller"){
            $this->module = "menu";
            $this->tplFile = "modules/".$this->module."/view/default.tpl";
             //echo $this->module;
        }
        if(get_class($this) == "Frontpage_controller"){
            
            
            $this->module = "frontpage";
            $this->tplFile = "modules/".$this->module."/view/default.tpl";
        }
        
        else{
           
        $this->tplFile = "modules/".$this->module."/view/$view.tpl";
        }
        
        
    }
      
    public function render()
    {
        $tpl = new Template($this->tplFile);
        $this->parseLanguage($tpl);
        foreach($this->params as $key => $value){
            $tpl->set($key, $value);
        }
        
        return $tpl->output($this);
    }
    
    private function parseLanguage($tpl)
    {
        if($this->obj != null){
            foreach($this->obj as $key => $value){
                $tpl->set($key, $value);
            }
        }
        
        //Språk
        $l = "modules/".$this->module."/lang/".$this->lang.".lang";
        if (!file_exists($l))
        {          
            $l = "modules/".$this->module."/lang/no_nb.lang";
            if(!file_exists($l))
            {  
                return;// "Error loading languagefile.:". $this->lang.".lang, and the default languagefile.";
            }
        }
        $langFile = fopen($l,"r");
        while($data = fgets($langFile)){
            if(strlen($data) > 3)
            {
                $tmp = explode("=", $data);
                $tpl->set(trim($tmp[0]),trim($tmp[1]));
            }  
        }
    }
    
    private function performAction(){
        $action = $_REQUEST['action'];
        try{
            
   
            if(method_exists($this, $action)){
                $this->$action();
            }
            else{
                throw new Exception();
            }
        }
        catch(Exception $e){
            
        }
    }
    public function getTopo() {
        return $this->topo;
    }

    public function setTopo($topo) {
        $this->topo = $topo;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getObj() {
        return $this->obj;
    }

    public function setObj($obj) {
        $this->obj = $obj;
    }

    public function getController() {
        return $this->controller;
    }

    public function setController($controller) {
        $this->controller = $controller;
    }

    public function getTplFile() {
        return $this->tplFile;
    }

    public function setTplFile($tplFile) {
        $this->tplFile = $tplFile;
    }

    public function getParams() {
        return $this->params;
    }

    public function setParams($params) {
        $this->params = $params;
    }

    public function getTitles() {
        return $this->titles;
    }

    public function setTitles($titles) {
        $this->titles = $titles;
    }



}

?>
