<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Widgets
 *
 * @author idarose
 */
class Widgets {
    //put your code here
    
    
    public static function randomLocation(){
        return Container::titledRoundedBox("Random location", "Hurra");
    }
    
    public static function randomFunFact(){
        include_once 'modules/funFact/model/FunFact.php';
        $array = array();
        try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "select * from funfacts ff inner join 
                        magmageopark.funfactsContent ffc on ff.funfactsId = ffc.funfactsId 
                        where ff.active = TRUE and ffc.lang = :lang ; ";


                $stmt = $dbh->prepare($sql);
               
                $stmt->bindParam(":lang", $_SESSION['lang']);
                
                $stmt->execute();
                
                 while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                       $f = new FunFact(0,$_SESSION['lang']);
                       
                       $f->setFactId($row['funfactsId']);
                       $f->title = $row['title'];
                       $f->factContent = $row['fact'];
                       
                       $array[] = $f;                 
                       
                    }
                 
                 if(count($array)>0){
                     $rand = rand(0, count($array)-1);
                 
                 $obj = $array[$rand];
                 
                 return Container::titledRoundedBox($obj->title, $obj->factContent);
                 }
                 else{
                     return "";
                 }
                 
                 
               
                 
                 
                 
                
                 
                // $this->factContent = $row['fact'];
                // $this->title = $row['title'];
                 
                //print_r($this->active);
            
              }catch (PDOException $e){
             
             echo $e;
             
            }
        
    }
    
    public static function randomFaq(){
        include_once 'modules/faq/model/Faq.php';
        $array = array();
        try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "select * from faq ff inner join 
                        magmageopark.faqContent ffc on ff.faqId = ffc.faq_faqId 
                        where ff.active = TRUE and ffc.lang = :lang ; ";


                $stmt = $dbh->prepare($sql);
               
                $stmt->bindParam(":lang", $_SESSION['lang']);
                
                $stmt->execute();
                
                 while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                       $f = new Faq(0,$_SESSION['lang']);
                       
                       $f->setfaqId($row['faqId']);
                       $f->question = $row['question'];
                       $f->faqContent = $row['answer'];
                       
                       $array[] = $f;                 
                       
                    }
                 
                 if(count($array)>0){
                     $rand = rand(0, count($array)-1);
                 
                 $obj = $array[$rand];
                 
                 return Container::titledRoundedBox("FAQ", "<h3>".$obj->question."</h3>".$obj->faqContent);
                 }
                 else{
                     return "";
                 }
                 
                 
               
                 
                 
                 
                
                 
                // $this->factContent = $row['fact'];
                // $this->title = $row['title'];
                 
                //print_r($this->active);
            
              }catch (PDOException $e){
             
             echo $e;
             
            }
        
    }
    
    
    public static function contactInfo(){
        $str = "Magma Geopark AS<br>
                Sokndalsveien 26<br>
                4370 Egersund<br>
                <script>document.write('post');
                        document.write('@');
                        document.write('magmageopark.com<br>');
                </script>
                +47 92877911 ";
       
        return Container::roundedCornerBox($str);
        
    }
}

?>
