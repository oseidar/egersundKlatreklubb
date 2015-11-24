<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Template
 *
 * @author idar
 */
class Template {
 
    protected $file,$langFile;

    protected $values = array();

    public function __construct($file) {
        $this->file = $file;
        
        
        
    }   


    public function set($key, $value) {
        $this->values[$key] = $value;
    }
    
    public function getLangFile() {
        return $this->langFile;
    }

    public function setLangFile($langFile) {
        $this->langFile = $langFile;
        
        
    }
    
    public function setObject($obj){
        foreach($obj as $key => $value){
            $this->values[$key] = $value;
        }
    }
    public function setArray($array){
        foreach($array as $key => $value){
            $this->values[$key] = $value;
        }
    }
    
    public function output($object=NULL) {
        if (!file_exists($this->file)) 
        {
            return "Error loading template file ($this->file).<br />";
        }
        $output = file_get_contents($this->file);
        $matches = array();
        $pattern = '/\[\@([a-z,A-Z,\:])*\(\)\]/';
        
        if( preg_match($pattern,$output)> 0){
        preg_match_all($pattern, $output, $matches);
        ////print_r($matches);
        if(sizeof($matches[0])>0){
            for($i = 0; $i< sizeof($matches[0]);$i++){
           @ $str = $matches[0][$i];
            $mName =  substr($str,2,(strlen($str)-5));
            $key =  substr($str,2,(strlen($str)-3));
            
            $static = explode("::", $mName);
            
            //echo $mName;
            
            if(count($static)>1){
               // //print_r($static);
                if(class_exists($static[0])){
                    //echo "klassen er på plass... ";
                    if(method_exists($static[0], $static[1])){
                        
                        //echo "metoden er på plass... ";
                        
                        $run = $static[0]."::".$static[1];
                     $value = call_user_func($run);
                    }else{
                        
                        /*
                         * Lete etter andre statiske funksjoner.. 
                         */
                        
                        
                        
                        
                        $value = "Ingen slik statisk funksjon";
                    }
                }
                
                else{
                    
                    if(file_exists(dirname(__FILE__)."/".$static[0].".php")){
                        //echo "Filen eksisterer... ";
                        include_once dirname(__FILE__)."/".$static[0].".php";
                        
                        if(method_exists($static[0], $static[1])){
                            $value = call_user_func(array($static[0],$static[1]));
                        }
                        else{
                            $value = "Klassen har ikke metoden.. ";
                        }
                    }
                    else{
                        $value =  "ingen klasse ved den navnet er tilgjengelig.";
                    }
                        
                        
                    
                    
                    
                }
                
            }
            
            
            elseif(method_exists($object, $mName)){
                
                $value = $object->$mName();
                
            }
            
            
            else{
                $router->params['content'] = "Feil i template/controller";
                $value = "Ingen slik funksjon";
            }
            $this->set($key, $value);
            
            }
        }
        }
        /*
         * Parsing av språkfil
         */
        if(isset($this->langFile)){
            $langFile = fopen($this->langFile,"r");
            
            while($data = fgets($langFile)){
                if(strlen($data) > 3){
                $tmp = explode("=", $data);
                
                $this->values[trim($tmp[0])] = trim($tmp[1]);
                }
                
                
            }
            
        }
        
        /*
         * Parsing av objekt
         */
        if(!empty($object->obj))
        foreach ($object->obj as $key => $value){
            $this->values[$key] = $value;
            
        }
        foreach ($this->values as $key => $value) {
            $tagToReplace = "[@$key]";
            $output = str_replace($tagToReplace, $value, $output);
        }

        return $output;
    }
    
}

?>
