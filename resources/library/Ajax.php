<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ajax
 *
 * @author idar
 */
class Ajax {
   public $module, $action, $view, $id;
   
   public $params = array();
    function __construct() {
        
        @$this->module = $_REQUEST['module'];
        @$this->action = $_REQUEST['action'];
        @$this->view = $_REQUEST['view'];
        @$this->id = $_REQUEST['id'];
        @$this->lang = $_REQUEST['lang'];
        if(empty($this->lang)){
            @$this->lang = $_SESSION['lang'];
        }
        if(empty($this->lang)){
            $this->lang = "no_nb";
        }
        $_SESSION['lang'] = $this->lang;
        
        if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}
        foreach($_POST as $key => $value){
            //print_r($_POST);
            
            if(!is_array($value)){
            $_POST[$key] = trim($_POST[$key]);
            //echo $_POST[$key]."<br>";
            
            }
        }
    }
    
    public function init(){
        
        $this->user = User::authenticate();
     if(!$this->user){
         $this->user = new User(0);
         $this->user->setFirstName("John");
         $this->user->setLastName("Doe");
         $this->user->setUserlevel(6);
     }
    }
    
    public function loadControllers(){
     if(!empty($this->module)){
         $file = 'modules/'.$this->module."/controller/".  ucfirst($this->module).'_controller.php';
         try{
            if(file_exists($file)) {
            include_once $file;
            }
            else{
                throw new Exception();
            }
         }
         catch(Exception $e){
             
            $this->router->params['content']  = "Kunne ikke laste kontroller... ". $e;
         }
     }
     else{
         // we load the frontpage... 
        die("No such controller");
     }
     
     
     
 }
 
 public function registerModules($json = false){
    
     $return = "No returnvalue";
        
        try{
            
            $classname = ucfirst($this->module)."_controller";
           
            try{
                if(class_exists($classname, false)){
            
                    $m = new $classname($this->user,$this);
                    
                    if(!empty($this->action)){
                        if(method_exists($m, $this->action)){

                            $method = $this->action;



                            $m->$method();
                            if(!$json){
                            $return = $m->render();
                            }else{
                                $return = $m->toJson();
                            }
                            

                        }
                        else{
                            throw new Exception();
                        }
                    }
                    else{

                        
                        if(!$json){
                            $return = $m->render();
                            }else{
                                $return = $m->toJson();
                            }

                    }
            
                }
                else{
                    throw new Exception();
                }
            }
            catch(Exception $e){
                $return = "Kunne ikke instantiere klasse eller metode: " . $e->getMessage();
            }
            
        }
        catch(Exception $e){
            $return = "Kunne ikke laste modul: " . $e->getMessage();
        }
    
        return $return;
    
    }
    

}

?>
