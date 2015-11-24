<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Member_Controller
 *
 * @author idar
 */
class Member_controller extends CoreController{
    //put your code here
    private $member;
    
    function __construct($user,$controller) {
        parent::__construct($user, $controller);
        if(!empty($_SESSION['member']))
        {
            $this->member = $_SESSION['member'];
        }
        else
        {
            header("location:?module=member&action=prepareLogin&view=loginForm");
        }
    }

    public function register(){
        
    }
    
    public function doRegister(){
        $save = true;
        if(empty($_REQUEST['pawned'])){
            
        }else{
            $save = false;
        }
       if( $_REQUEST['password'] != $_REQUEST['password2']){
           return false;
       }
       if( $_REQUEST['mail'] != $_REQUEST['mail2']){
           return false;
       }
       if(empty($_REQUEST['mail'])){
           return false;
       }
       if(empty($_REQUEST['password'])){
           return false;
       }
       
       if(Member::checkMail($_REQUEST['mail']) >0){
           return false;
       }
       
        $member = new Member(0);
       //print_r($_REQUEST['password']);
        $member->setBirthDate(date("Y-m-d",  strtotime($_REQUEST['dob'])));
        $member->firstName = $_REQUEST['firstname'];
        $member->lastName = $_REQUEST['lastname'];
        $member->setPassword(trim($_REQUEST['password']));
        
       
       // print_r($member->password);
        $member->setEmail(trim($_REQUEST['mail']));
        $member->setAdress(" ");
        $member->setZip(4370);
        $member->setClub("EKTK");
        $member->memberlevel = 5;
        $member->parentId = 0;
        $member->isParent = 1;
        if($save){
            $member->save();
        }   
    }
    
    public function doLogin(){
        
        $member = Member::authenticate();
        
        if(!empty($_SESSION['member'])){
            $_SESSION['member']->loadChildren();
           // print_r($_SESSION['member']);
            $tpl = new Template("./modules/member/view/loggedInInfo.tpl");
            
            
            $this->params['content'] = $tpl->output();
        }
        else{
            $tpl = new Template("./modules/member/view/wrongPassword.tpl");
            
            $this->params['content'] = $tpl->output();
        }
    }
    
    public function getMe(){
        $member = new Member(0);
        
        $member = $_SESSION['member'];
        
        $member->loadChildren();
        
        
    }
    
    public function logOut(){
        unset($_SESSION['member']);
        unset($_SESSION['bookingContext']);
        
        header("Location:index.php");
    }
    
    public function getDetails(){
        $this->obj = $this->member;
    }
    
    public function getCurrentStatus(){
            $year = date("Y");
            $str = "<div><span class='name bold'>Navn</span>
                         <span class='year bold'>År</span>
                         <span class='memberType bold'>Medlemstype</span>
                         <span class='paid bold'>Betalt</span></div>";
            $status = array();
             $status[0] =  $this->member->getCurrentStatus();
             $count = 1;
             foreach($this->member->getChildren() as $value){
                 $status[$count] = $value->getCurrentStatus();
                 $count++;
             }
            $numNotPaid = 0;
            $countMembers = 0;
             foreach($status as $key => $value){
                 
                 if(!empty($value)){
                 
                 //print_r($value);
                 //echo "<br><br>";
                 $countMembers++;
                 if($value['paid'] == 1){
                         $betalt = "betalt";
                         
                     }
                     else{
                         $betalt = "Ikke betalt";
                         $numNotPaid++;
                     }
                 if($key == 0){
                     
                 $str .= "<div><span class='name'>".$this->member->getFullName()."</span>
                         <span class='year'>$year</span>
                         <span class='memberType'>".  Helper::utf($value['title'])."</span>
                         <span class='paid'> $betalt</span></div>";
                 }
                 else{
                     $childen = $this->member->getChildren();
                     $child;
                     foreach($childen as $val){
                         if($value['member_memberId'] == $val->memberId){
                             $child = $val;
                             $str .= "<div><span class='name'>".$child->getFullName()."</span>
                                     <span class='year'>$year</span>
                                     <span class='memberType'>".Helper::utf($value['title'])."</span>
                                     <span class='paid'> $betalt</span></div>";
                         }
                     }
                     
                     
                     //print_r($child);
                     
                 }
                 
                
                 
                 
                 
             }
             }
            
             if($countMembers<1){
                 $str .="<div >Ingen er medlemmer ennå! </div>";
             }
             
             if($numNotPaid>0){
                 $str .= "<input type='button' onclick='getBill()' title='gå til faktura' value='Betal utestående medlemskap' />";
             }
              $nonMembers = $this->member->getNonMembers(date("Y"));
              if(count($nonMembers)>0){
              $str .= "<h4>Tilknytte personer som ikke er medlemmer</h4>";
              $str .= "<span class='name bold left'>Navn</span>
                                     <span class='year bold center'>År</span>
                                     
                                     <span class='bold center' >Gjør til medlem</span>";
              foreach($nonMembers as $nonMember){
                         
                             $str .= "<div><div><span class='name left'>".$nonMember->getFullName()."</span>
                                     <span class='year'>$year</span>
                                     
                                     <span class='confirmBtn center inlineBlock' title='Endre status til medlem' onclick='makeMeMember(".$nonMember->memberId.")'>[V]</span>
                                     
                                     </div>
                                     <div id='makeMeMemberContainer_".$nonMember->memberId."' style='display:none'></div>
                                     </div>";
                       
                     }
              }
            return $str;
    }
    public function getChildren(){
        $str = "";
       foreach($this->member->getChildren() as $child){
           //print_r($value);
           $tpl = new Template("app/view/member/childLine.tpl");
           
           
           foreach ($child as $key => $value){
               $tpl->set($key, $value);
           }
           $str .= $tpl->output();
           
       }
        
       $this->params["content"] = $str;
          
    }

    public function getPreviousMembership() {

    }
    public function payCurrentMembership(){

    }
    
    public function prepareEditMember(){
           $this->obj =  new Member($this->controller->id);
           
         
    }
    
    /*public function findCity(){
        $zip = $_GET['zip'];
        $f =  fopen("http://adressesok.posten.no/nb/postal_codes/search?q=".$zip , "r");
          $c = fread($f, 200000);
          
          $tmp = explode("<body", $string)
        $doc = new DOMDocument();
        $doc->loadHTMLFile( );
         /          
          
          
         $codes =  $doc->getElementById("postal_codes");
          
          $this->params["content"] = $codes;
        
    }*/
    


public function saveEditMember(){
    $m = new Member($this->controller->id);
    @$m->active = $_REQUEST['active'];
    $m->firstName = $_REQUEST['firstName'];
    $m->lastName = $_REQUEST['lastName'];
    $m->adress = $_REQUEST['adress'];
    $m->club = $_REQUEST['club'];
    $m->phone = $_REQUEST['phone'];
    $m->zip = $_REQUEST['zip'];
    $m->email = $_REQUEST['mail'];
    $m->birthDate = $_REQUEST['bDate'];
    try{
    if($m->save() != FALSE){
        
        $tpl = new Template("app/view/member/childLine.tpl");
        foreach ($m as $key => $value){
               $tpl->set($key, $value);
           }
           //$str .= 
        
        
        $this->params['content'] = $tpl->output();
    }else{
        throw new Exception();
    }
    }
 catch (Exception $e){
     $this->params['content'] = "Kunne ikke lagre bruker: " . $e;
 }
         
}

public function saveMyDetails(){
    $m = $this->controller->member;
   // @$m->active = $_REQUEST['active'];
    $m->firstName = $_REQUEST['firstName'];
    $m->lastName = $_REQUEST['lastName'];
    $m->adress = $_REQUEST['adress'];
    $m->club = $_REQUEST['club'];
    $m->phone = $_REQUEST['phone'];
    $m->zip = $_REQUEST['zip'];
    $m->email = $_REQUEST['mail'];
    $m->birthDate = $_REQUEST['bDate'];
    try{
    if($m->save() != FALSE){
        
        
        
        
        $this->params['content'] = "Informasjon ble oppdatert";
    }else{
        throw new Exception();
    }
    }
 catch (Exception $e){
     $this->params['content'] = "Kunne ikke lagre bruker: " . $e;
 }
         
}

public function saveNewMember(){
    
    
    
    $parent = $this->controller->member;
    $m = new Member(0);
    @$m->active = $_REQUEST['active'];
    $m->firstName = $_REQUEST['firstName'];
    $m->lastName = $_REQUEST['lastName'];
    $m->adress = $_REQUEST['adress'];
    $m->club = $_REQUEST['club'];
    $m->phone = $_REQUEST['phone'];
    $m->zip = $_REQUEST['zip'];
    $m->email = $_REQUEST['mail'];
    $m->setBirthDate(date("Y-m-d",  strtotime($_REQUEST['bDate'])));
    $m->memberlevel = 5;
    $m->isParent = FALSE;
    $m->setParent($parent);
    //print_r($m);
    print_r($_REQUEST);
    if($_REQUEST['pawned'] == ""){
            try{
            if($m->save() != FALSE){

                $tpl = new Template("app/view/member/childLine.tpl");
                foreach ($m as $key => $value){
                    $tpl->set($key, $value);
                }
                //$str .= 


                $this->params['content'] = $tpl->output();
            }else{
                throw new Exception();
            }
            }
        catch (Exception $e){
            $this->params['content'] = "Kunne ikke lagre bruker: " . $e;
        }
    }
         
}

public function prepareMyDetails(){
    $this->obj = $this->member;
}

public function prepareMembership(){
    $this->obj = new Member($this->controller->id);
    //print_r($this->obj);
    $hasMainMember = false;
    if($this->obj->isParent){
        
        $this->obj->loadChildren();
        
        if($this->obj->getMemberType() == 1){
            $hasMainMember = TRUE;
        }
        foreach($this->obj->getChildren() as $children){
               
            if($children->getMemberType() == 1){
                $hasMainMember = TRUE;
            }
        }
        
    }
    else{
        $parent = new Member($this->obj->parentId);
        $parent->loadChildren();
        if($parent->getMemberType() == 1){
             $hasMainMember = TRUE;
        }
        foreach($parent->getChildren() as $children){
            if($children->getMemberType() == 1){
                $hasMainMember = TRUE;
            }
        }
    }
    
    if($hasMainMember){
        $this->params['options'] = ' <option value="2">Husstandsmedlem</option>';
    }
    else{
        $this->params['options'] = '<option value="1">Ordinær medlem</option>';
    }
    
    
}
public function saveMemberShip(){
    
    $my = new MemberYear();
    
    
    $my->setPaid(0);
    $my->setYear(MemberYear::getCurrentYear());
    $my->setMemberId($this->controller->id);
    $my->setType($_REQUEST['type']);
    if($my->save()){
    
        $this->params['content'] = "Medlemskap opprettet";
    }
    else{
        $this->params['content'] = "Opprettelse av medlemskap feilet";
    }
}

public function getBill(){
    $str = "";
    $price = 0;
    $rows = $this->controller->member->getUnpaidMemberships();
    
    foreach($rows as $row){
        $tpl = new Template("app/view/bill/billLine.tpl");
        $price += $row['price'];
        
        Member::markBillDate($row);
        foreach($row as $key =>$value){
            $tpl->set($key,  Helper::utf($value));
        }
        $str .= $tpl->output();
    
    }
    $this->params['price'] = $price;
    $this->params["rows"]= $str;
    $this->params['year'] = MemberYear::getCurrentYear();
    
    $date = strtotime("+2 week");
    $this->params["dueDate"] = date("d.m.Y",$date);
    
    
    
    
}

public function getCourses(){
    $this->params['content'] = $this->getMyCourses();
}

public function requestPassword(){
    $mail = $_REQUEST['mail'];
    $firstName = $_REQUEST['firstName'];
    
    $member = Member::getByMail($mail, $firstName);
    if($member->getMemberId()== NULL || $member->getMemberId() == 0){
        $this->params['content'] = "Finner ikke bruker. Ta kontakt med administrator av siden.";
    }
    else{
    $newpass = substr($member->getPassword(), 0,8);
    
    
    
    $member->setPassword($newpass);
    $message = "Du, eller noen som kjenner di epost har bedt om nytt passord \n";
    $message .= "Ditt nye passord er: $newpass \n";
    $message .= "Vennlig hilsen medlemssystemet til EKTK :) ";
    
    
    $m = new Mail($mail, "noreply@egersundklatreklubb.com", $message, "Endring av passord EKTK");
    
    $m->fromName = "postmaster";
    $ms = $m->send();
    if($ms){
        if($member->changePassword()){
            $this->params['content'] = "Passordet ditt ble oppdatert";
        }
    }
    }
    
    //
    
    
}

public function resetMemberships(){
    $this->member = new Member($this->controller->id);
    
    $this->member->loadChildren();
    
    $this->member->deleteMembership();
    foreach($this->member->getChildren() as $child){
       $child->deleteMembership(); 
    }
   // print_r($this->member);
    $this->params['content'] = "Slettet....";
}


public function getMyCourses(){
    
        $str = "";
    
            try{
                $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "select courseId from mccbase.member_has_course where memberId = :mid;";

                //

                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':mid',$this->member->memberId,PDO::PARAM_INT);
                
                $array = array();
                $stmt->execute();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    
                    $c = new Course($row['courseId']);
                    $c->loadPartisipants();
                    
                    $array[] = $c;
                    
                    
                }
                foreach ($array as $co){
                    foreach($co->getPartisipants() as $p){
                        $status = "";
                        if($p->getMemberId() == $this->member->memberId){
                            if($p->getPaid() == 1){
                                $status = "Betalt";
                            }
                            else{
                                $status = "Ikke-betalt";
                            }
                        }
                    }
                    $str .= "<div>". $co->courseName ." Status: $status <button onclick='createCourseBill(".$co->getCourseId().")'>Klikk for faktura </button>";
                    
                        $payPal = new PayPal();
                        $payPal->setAmount($co->price);
                        $payPal->itemName = "Kurs: " . $co->courseName;
                        
                        $token = $payPal->getToken();
                        $_SESSION[urldecode($token)] = $co;
                        
                       $url = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=".$token;
                       $a = "<a href='$url'>Betal med kort (paypal)</a>";
                       
                     if($this->member->memberlevel < 2)  
                         $str .= $a;
                    //$tpl = new Template("app/view/courses/paypalCourseForm.tpl");
                    //$tpl->set("amount",$co->price);
                    //$tpl->set("id",$co->courseId);
                    //$str .= $tpl->output();
                     $str .= "</div>";
                }
                
                
                
            }
            catch(PDOExeption $e){
                    
                    die("Kunne ikke  laste Type: " . $e);
            }
        return $str; 
    }
    
    public function myMembership()
    {        
       
    }
    
    public function prepareLogin()
    {
        
    }
}



