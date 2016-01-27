<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Idar
 */
class User
{
    private $userId, $firstName, $lastName, $mail, $password, $salt, $activated, $activationToken, $tokenExpiration, $lastLogin;
    
    function __construct($userId)
    {
        $this->userId = $userId;
        if($this->userId != 0){
             try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "select * from `user` where userId = :id ; ";

                //

                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':id',$this->userId,PDO::PARAM_INT);

                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->firstName = $row['firstName'];
                $this->lastName = $row['lastName'];
                $this->userlevel = $row['userlevel'];
                $this->email = $row['mail'];
                $this->activated = $row['activated'];
                $this->lastLogin = $row['lastLogin'];
            }
            catch(PDOExeption $e){

                    die("Kunne ikke  laste Bruker: " . $e);
            }
        }
    }
    
    function getUserId()
    {
        return $this->userId;
    }

    function getFirstName()
    {
        return $this->firstName;
    }

    function getLastName()
    {
        return $this->lastName;
    }

    function getMail()
    {
        return $this->mail;
    }

    function getActivated()
    {
        return $this->activated;
    }

    function getActivationToken()
    {
        return $this->activationToken;
    }

    function getLastLogin()
    {
        return $this->lastLogin;
    }

    function setUserId($userId)
    {
        $this->userId = $userId;
    }

    function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    function setMail($mail)
    {
        $this->mail = $mail;
    }

    function setActivated($activated)
    {
        $this->activated = $activated;
    }

    function setActivationToken($activationToken)
    {
        $this->activationToken = $activationToken;
    }

    function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    function getHashedPassword()
    {
        return hash('sha512', $this->password . md5($salt));
    }
    
    function createActivationToken()
    {   
        $this->activationToken = hash('sha512', $this->firstName . date('Y-m-d H:i:s') );
    }
    
    public static function activate()
    {
        
    }
    public static function authenticate()
    {
        
    }
    
    function createUser()
    {
        
    }
    
        public function save(){
       if($this->userId == 0 || empty($this->userId)){
       try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "INSERT INTO `user` ( firstName, lastName,username ,userlevel,password,mail) VALUES ( :firstName, :lastName, :username,:level,:password,:mail);";


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
      public function setUserLevel($userlevel) {
       $this->userLevel = $userlevel;
   }
    

}
