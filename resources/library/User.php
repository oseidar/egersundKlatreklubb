<?php

/*
 * Core userclass. Loaded at startup. 
 */

/**
 * Description of User
 *
 * @author idar
 */
class User {
    
    public $userId,$username,$password, $email, $firstName , $lastName, $userlevel, $guestbookNic, $active;
    
    function __construct($userId) {
        $this->userId = $userId;
        
        if($this->userId != 0){
             try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "select * from `User` where userId = :id ;
";

                //

                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':id',$this->userId,PDO::PARAM_INT);
                

                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->firstName = $row['firstname'];
                $this->username = $row['username'];
                $this->lastName = $row['lastname'];
                $this->userlevel = $row['userlevel'];
                $this->guestbookNic = $row['guestbookNic'];
                $this->email = $row['mail'];
                $this->active = $row['active'];
                
                
                


            }
            catch(PDOExeption $e){

                    die("Kunne ikke  laste Bruker: " . $e);
            }
        }
    }
    
    public function save(){
       if($this->userId == 0 || empty($this->userId)){
       try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "INSERT INTO `User` ( firstName, lastName,username ,userlevel,password,mail) VALUES ( :firstName, :lastName, :username,:level,:password,:mail);";


                //

                $stmt = $dbh->prepare($sql);
                                
                $stmt->bindParam(':firstName',$this->firstName,PDO::PARAM_STR);
                $stmt->bindParam(':lastName',$this->lastName,PDO::PARAM_STR);
                $stmt->bindParam(':username',$this->username,PDO::PARAM_STR);
                $stmt->bindParam(':level', $this->userlevel,PDO::PARAM_INT);
                $stmt->bindParam(':password',$this->password,PDO::PARAM_STR);
               
                $stmt->bindParam(':mail', $this->email,PDO::PARAM_STR);
                
                
               

                $stmt->execute();
                    return "Bruker lagret"; //Language::_savingTickOk;
                   }
            catch(PDOExeption $e){

                    return false;
            }
       }
       else{
           
           try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "UPDATE `User` SET firstName = :firstName, lastName = :lastName,`username` = :username, guestbookNic = :guestbookNic ,mail= :mail, password = :password WHERE userId = :uid LIMIT 1 ;"; 

                   

                //

                $stmt = $dbh->prepare($sql);
                                
                $stmt->bindParam(':firstName',$this->firstName,PDO::PARAM_STR);
                $stmt->bindParam(':lastName',$this->lastName,PDO::PARAM_STR);
                $stmt->bindParam(':username',$this->username,PDO::PARAM_STR);
                $stmt->bindParam(':mail',$this->email,PDO::PARAM_STR);
                
                $stmt->bindParam(':password',$this->password,PDO::PARAM_STR);
                $stmt->bindParam(':guestbookNic',$this->guestbookNic,PDO::PARAM_STR);
                $stmt->bindParam(':uid', $this->userId,PDO::PARAM_INT);
                
                
                
               

                $stmt->execute();
                    return "Bruker lagret"; //Language::_savingTickOk;
                   }
            catch(PDOExeption $e){

                    return false;
            }
           
       }



   }
   public function getGuestbookNic() {
       return $this->guestbookNic;
   }

   public function setGuestbookNic($guestbookNic) {
       $this->guestbookNic = $guestbookNic;
   }

      public function getUserId() {
       return $this->userId;
   }

   public function setUserId($userId) {
       $this->userId = $userId;
   }

   public function getUsername() {
       return $this->username;
   }

   public function setUsername($username) {
       $this->username = $username;
   }

   public function getPassword() {
       return $this->password;
   }

   public function setPassword($password) {
       $this->password = md5($password);
   }

   public function getEmail() {
       return $this->email;
   }

   public function setEmail($email) {
       $this->email = $email;
   }

   public function getFirstName() {
       return $this->firstName;
   }

   public function setFirstName($firstName) {
       $this->firstName = $firstName;
   }

   public function getLastName() {
       return $this->lastName;
   }

   public function setLastName($lastName) {
       $this->lastName = $lastName;
   }

   public function getUserlevel() {
       return $this->userlevel;
   }

   public function setUserlevel($userlevel) {
       $this->userlevel = $userlevel;
   }
   
   public function getFullName(){
       
       return $this->firstName ." ".$this->lastName;
       
   }
   public static function authenticate(){
       //print_r($_REQUEST);
       $user = new User(0);
       if(empty($_SESSION['user']) && !empty($_REQUEST['username']) && !empty($_REQUEST['password'])){
           $username = $_REQUEST['username'];
           $password = $_REQUEST['password'];
           
           $user->setUsername($username);
           $user->setPassword($password);
            
           try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "select count(username)as nr   from `User` where username = :username && password = :password ;";

                //

                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':username',$user->username,PDO::PARAM_INT);
                $stmt->bindParam(':password', $user->password, PDO::PARAM_STR);

                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if($row['nr'] == 1){
                    $dbh2 = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql2 = "select *   from `User` where username = :username && password = :password ;";

                //

                $stmt2 = $dbh2->prepare($sql2);
                $stmt2->bindParam(':username',$user->username,PDO::PARAM_INT);
                $stmt2->bindParam(':password', $user->password, PDO::PARAM_STR);

                $stmt2->execute();
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                    
                    
                    
                    $user->firstName = $row2['firstname'];
                    $user->userId = $row2['userId'];
                
                    $user->lastName = $row2['lastname'];
                    $user->userlevel = $row2['userlevel'];
                    
                    $user->email = $row2['mail'];
                    
                    ////print_r($user);
                    $_SESSION['user'] = $user;
                    
                }
                else{
                    
                    $user->firstName = "John";
                    $user->password = "";
                    $user->userlevel = 6;
                    $user->lastName = "Doe";
                    $user->guestbookNic = "guest";
                    
                    
                }
                
                
               
                
                
                ////print_r($user);
                return $user;
                
                

            }
            catch(PDOExeption $e){

                    echo "Kunne ikke  laste Bruker: " . $e;
            }
           
           
           
       }
       elseif(!empty($_SESSION['user'])){
           return  $_SESSION['user'];
       }
       else{
           
           return false;
       }
       
       
       
   }
   
   public static function userToUrl($var){
       ////print_r($var);
       $str =  $var;
       try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = 'select u.*, concat_ws( " ",firstname,lastname) as `name` from `User` u where concat_ws(" ",firstname,lastname) = :name ;';

                
                //

                $stmt = $dbh->prepare($sql);
                
                $stmt->bindParam(':name',$var,PDO::PARAM_INT);
                

                $stmt->execute();
                $nr = $stmt->rowCount();
                
                ////print_r($nr);
                
               
                if($nr == 1){
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    ////print_r("Ett treff");
                    $str = "<a href='index.php?module=user&action=&view=viewUser&id=".$row['userId']."'>".$row['name']."</a>";
                    
                }
                else{
                    $str = $var;
                   // //print_r($str);
                }
                
                
                


            }
            catch(PDOExeption $e){

                    echo ("Kunne ikke  laste Bruker: " . $e);
            }
       
       return $str;
   }
    
   
   public function getNumComments(){
       
       try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = 'SELECT count(*) as num from gjestebok where userId = :id';


                //

                $stmt = $dbh->prepare($sql);
                
                $stmt->bindParam(':id',$this->userId,PDO::PARAM_INT);
                

                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['num'];
                
                ////print_r($nr);
                
               
                
                
                
                


            }
            catch(PDOExeption $e){

                    return "Kunne ikke  laste brukerdata: " . $e;
            }
       
       
       
   }
 
   
   
   
   
   public function getTickList($currentUserId){
       //echo "<h3> current ".$currentUserId. " this" . $this->userId."</h3>";
       $array = array();
       include_once 'modules/topo/model/Ascent.php';
       include_once 'modules/topo/model/Boulder.php';
       include_once 'modules/topo/model/BoulderMedia.php';
       include_once 'modules/topo/model/BoulderComments.php';
       
       try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "select uhp.* from User_has_problemer uhp inner join problemer p on uhp.problemId = p.idproblemer where uhp.userId = :userId ORDER BY uhp.dato desc; ";

                //

                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':userId',$this->userId,PDO::PARAM_STR);

                $stmt->execute();
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $tmp = new Ascent(0, 0);
                $b = new Boulder($row['problemId']);
                $b->loadAscents();
                $b->loadComments();
                $b->loadMediaList();
                $tmp->setId($row['ascentId']);
                $tmp->setUserId($row['userId']);
                $tmp->setAscentDate($row['dato']);
                $tmp->setStars($row['stars']);
                $tmp->setboulderId($row['problemId']);
                $tmp->setSuggestGrade($row['suggestGrade']);
                $tmp->setComment($row['comment']);
                $tmp->setBoulder($b);
                $tmp->setUser($this);
               //echo "test<br> load accents<br>";
                $array[] = $tmp;
                }
                //echo "Antaløl bestigninger: ".sizeof($this->ascents);
                



        }
        catch(PDOExeption $e){

                return "Connection failed: ".$e->getMessage();
        }
       
       $ascents = $array;
       $str = "<h3 class='orange'>Bestigninger</h3>";
        if(count($ascents)>0){
            
        $str .= "<table id='userAscentTable' >";
       
        $class = "";
        $counter = 0;
        foreach($ascents as $key=>$value){
                
            if($counter%2 == 0){
                $class="even";
            }
            else{
                $class = "odd";
            }
            
             $str .= "<tr class='$class'>";
             $str .= "<td><a href='http://www.buldreinfo.com/index.php?module=topo&action=&view=boulder&id=".$value->getboulderId()."'>".$value->getBoulder()->getName()."</a></td>";
             $str .= "<td>".$value->getComment()."</td>";
             $str .= "<td>#ticks:".count($value->getBoulder()->getAscents())."</td>";
             $str .= "<td>#media:".count($value->getBoulder()->getMediaList())."</td>";
             $str .= "<td>#kommentarer:".count($value->getBoulder()->loadCommentsAsArray())."</td>";
             $str .= "<td>".$value->getSuggestGradeReal()."</td>";
             $str .= "<td>".$value->getAscentDate()."</td>";
             $str .=" <td><img src='public/Stars/".$value->getStarImage()."' alt='starImage'/></td>";
             
             if($this->userId == $currentUserId){
             $str .= "<td style='width:17px;'><a style='color:#9999ee; font-weight:bolder;text-decoration:none;  ' class='inlineBlock edit' href='javascript:editAscent(".$value->getId().")' title='rediger'>[ / ]</a></td>";
             $str .= "<td><a style='color:#aa0000; font-weight:bolder;text-decoration:none' href='javascript:deleteAscent(".$value->getId().")' title='slett'>[X]</a></td>";
             }
             
             
             $str .= "</tr>";
            
             $counter++;
             
        }
        $str .= "</table>";
        }
        else{
            return "<h3 class='orange'>Ingen registrerte bestigninger</h3>";
        }
        
        return $str;
    
   }
   
   public function getNumAscents(){
       
       try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = 'SELECT count(*) as num from User_has_problemer where userId = :id';


                //

                $stmt = $dbh->prepare($sql);
                
                $stmt->bindParam(':id',$this->userId,PDO::PARAM_INT);
                

                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['num'];
                
                ////print_r($nr);
                
               
                
                
                
                


            }
            catch(PDOExeption $e){

                    return "Kunne ikke  laste brukerdata: " . $e;
            }
       
       
       
   }
   public function getNumImages(){
       
       try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = 'SELECT count(*) as num from media where userId = :id';


                //

                $stmt = $dbh->prepare($sql);
                
                $stmt->bindParam(':id',$this->userId,PDO::PARAM_INT);
                

                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['num'];
                
                ////print_r($nr);
                
               
                
                
                
                


            }
            catch(PDOExeption $e){

                    return "Kunne ikke  laste brukerdata: " . $e;
            }
       
       
       
   }
   
   public function getNumFa(){
       $name = $this->getFullName();
       $name = "%".$name."%";
       try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = 'SELECT count(*) as num from problemer where FA LIKE :id';


                //

                $stmt = $dbh->prepare($sql);
                
                $stmt->bindParam(':id',$name,PDO::PARAM_INT);
                

                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['num'];
                
                ////print_r($nr);
                
               
                
                
                
                


            }
            catch(PDOExeption $e){

                    return "Kunne ikke  laste brukerdata: " . $e;
            }
       
       
       
   }
    public static  function test(){
        return "dette er en test... ";
    }

    
    
}

?>
