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
class Member_controller extends CoreController
{

    //put your code here
    private $member;

    function __construct($user, $controller)
    {
        parent::__construct($user, $controller);
        if (!empty($_SESSION['member']))
        {
            $this->member = $_SESSION['member'];
        }
        elseif ($this->controller->view != "loginForm" && $this->controller->action != "register" && $this->controller->action != "doLogin" && $this->controller->view != "requestPassword" && $this->controller->action != "requestPassword")
        {
            header("location:?module=member&action=prepareLogin&view=loginForm");
        }
    }

    public function register()
    {
        
    }

    public function doRegister()
    {
        $save = true;
        if (empty($_REQUEST['pawned']))
        {
            
        }
        else
        {
            $save = false;
        }
        if ($_REQUEST['password'] != $_REQUEST['password2'])
        {
            return false;
        }
        if ($_REQUEST['mail'] != $_REQUEST['mail2'])
        {
            return false;
        }
        if (empty($_REQUEST['mail']))
        {
            return false;
        }
        if (empty($_REQUEST['password']))
        {
            return false;
        }

        if (Member::checkMail($_REQUEST['mail']) > 0)
        {
            return false;
        }

        $member = new Member(0);
        //print_r($_REQUEST['password']);
        $member->setBirthDate(date("Y-m-d", strtotime($_REQUEST['dob'])));
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
        if ($save)
        {
            $member->save();
        }
    }

    public function doLogin()
    {
        $member = Member::authenticate();
        //print_r($member);
        //print_r($_SESSION);
        if (!empty($_SESSION['member']))
        {
            $_SESSION['member']->loadChildren();
            // print_r($_SESSION['member']);
            $tpl = new Template("./modules/member/view/loggedInInfo.tpl");


            $this->params['content'] = $tpl->output();
        }
        else
        {
            $tpl = new Template("./modules/member/view/wrongPassword.tpl");

            $this->params['content'] = $tpl->output();
        }
    }

    public function getMe()
    {
        $member = new Member(0);

        $member = $_SESSION['member'];

        $member->loadChildren();
    }

    public function logOut()
    {
        unset($_SESSION['member']);
        unset($_SESSION['bookingContext']);

        header("Location:index.php");
    }

    public function getDetails()
    {
        $this->obj = $this->member;
    }

    public function getCurrentStatus()
    {
        $year = Year::getYear();
        $str = "<div><span class='name bold'>Navn</span>
                         <span class='year bold'>År</span>
                         <span class='memberType bold'>Medlemstype</span>
                         <span class='paid bold'>Betalt</span></div>";
        $status = array();
        $status[0] = $this->member->getCurrentStatus();
        $count = 1;
        foreach ($this->member->getChildren() as $value)
        {
            $status[$count] = $value->getCurrentStatus();
            $count++;
        }
        $numNotPaid = 0;
        $countMembers = 0;
        foreach ($status as $key => $value)
        {

            if (!empty($value))
            {

                //print_r($value);
                //echo "<br><br>";
                $countMembers++;
                if ($value['paid'] == 1)
                {
                    $betalt = "betalt";
                }
                else
                {
                    $betalt = "Ikke betalt";
                    $numNotPaid++;
                }
                if ($key == 0)
                {

                    $str .= "<div><span class='name middle'>" . $this->member->getFullName() . "</span>
                         <span class='year middle'>$year</span>
                         <span class='memberType middle'>" . Helper::utf($value['title']) . "</span>
                         <span class='paid middle'> $betalt</span></div>";
                }
                else
                {
                    $childen = $this->member->getChildren();
                    $child;
                    foreach ($childen as $val)
                    {
                        if ($value['member_memberId'] == $val->memberId)
                        {
                            $child = $val;
                            $str .= "<div><span class='name middle'>" . $child->getFullName() . "</span>
                                     <span class='year middle'>$year</span>
                                     <span class='memberType middle'>" . Helper::utf($value['title']) . "</span>
                                     <span class='paid middle'> $betalt</span></div>";
                        }
                    }


                    //print_r($child);
                }
            }
        }

        if ($countMembers < 1)
        {
            $str .="<div >Ingen er medlemmer ennå! </div>";
        }

        if ($numNotPaid > 0)
        {
            $str .= "<input style='margin:20px 0 30px 0; padding:10px;' type='button' onclick='getBill()' title='gå til faktura' value='Betal utestående medlemskap' />";
        }
        $nonMembers = $this->member->getNonMembers($year);
        if (count($nonMembers) > 0)
        {
            $str .= "<h4 style='margin-top:20px;'>Tilknytte personer som ikke er medlemmer</h4>";
            $str .= "<span class='name bold left middle'>Navn</span>
                        <span class='year bold center middle'>År</span>
                        <span  class='bold center middle' >Gjør til medlem</span>";
            foreach ($nonMembers as $nonMember)
            {

                $str .= "<div  id='nonMemberTable'>
                                <div  style='vertical-align: middle; position:relative; height:30px;'>
                                    <div  class='name left middle  inlineBlock'>" . $nonMember->getFullName() . "</div>
                                    <div class='year inlineBlock center middle'>$year</div>
                                    <div class='confirmBtn center inlineBlock middle' title='Endre status til medlem' onclick='makeMeMember(" . $nonMember->memberId . ")'>[V]</div>
                                </div>
                                <div id='makeMeMemberContainer_" . $nonMember->memberId . "' style='display:none'></div>
                            </div>";
            }
        }
        return $str;
    }

    public function getChildren()
    {
        $this->member->loadChildren();
        $str = "";
        foreach ($this->member->getChildren() as $child)
        {
            //print_r($value);
            $tpl = new Template("./modules/member/view/childLine.tpl");


            foreach ($child as $key => $value)
            {
                $tpl->set($key, $value);
            }
            $str .= $tpl->output();
        }

        $this->params["content"] = $str;
    }

    public function getPreviousMembership()
    {
        
    }

    public function payCurrentMembership()
    {
        
    }

    public function prepareEditMember()
    {
        $this->obj = new Member($this->controller->id);
    }

    /* public function findCity(){
      $zip = $_GET['zip'];
      $f =  fopen("http://adressesok.posten.no/nb/postal_codes/search?q=".$zip , "r");
      $c = fread($f, 200000);

      $tmp = explode("<body", $string)
      $doc = new DOMDocument();
      $doc->loadHTMLFile( );
      /


      $codes =  $doc->getElementById("postal_codes");

      $this->params["content"] = $codes;

      } */

    public function saveEditMember()
    {
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


        try
        {
            if ($m->save() != FALSE)
            {

                $tpl = new Template("./modules/member/view/childLine.tpl");
                foreach ($m as $key => $value)
                {
                    $tpl->set($key, $value);
                }
                $this->params['content'] = $tpl->output();
            }
            else
            {
                throw new Exception();
            }
        }
        catch (Exception $e)
        {
            $this->params['content'] = "Kunne ikke lagre bruker: " . $e;
        }
    }

    public function saveMyDetails()
    {
        $m = $this->member;
        // @$m->active = $_REQUEST['active'];
        $m->firstName = $_REQUEST['firstName'];
        $m->lastName = $_REQUEST['lastName'];
        $m->adress = $_REQUEST['adress'];
        $m->club = $_REQUEST['club'];
        $m->phone = $_REQUEST['phone'];
        $m->zip = $_REQUEST['zip'];
        $m->email = $_REQUEST['mail'];
        $m->birthDate = $_REQUEST['bDate'];
        try
        {
            if ($m->save() != FALSE)
            {

                $this->params['content'] = "Informasjon ble oppdatert";
            }
            else
            {
                throw new Exception();
            }
        }
        catch (Exception $e)
        {
            $this->params['content'] = "Kunne ikke lagre bruker: " . $e;
        }
    }

    public function saveNewMember()
    {
        $parent = $this->member;
        $m = new Member(0);
        @$m->active = $_REQUEST['active'];
        $m->firstName = $_REQUEST['firstName'];
        $m->lastName = $_REQUEST['lastName'];
        $m->adress = $_REQUEST['adress'];
        $m->club = $_REQUEST['club'];
        $m->phone = $_REQUEST['phone'];
        $m->zip = $_REQUEST['zip'];
        $m->email = $_REQUEST['mail'];
        $m->setBirthDate(date("Y-m-d", strtotime($_REQUEST['bDate'])));
        $m->memberlevel = 5;
        $m->isParent = FALSE;
        $m->setParent($parent);
        //print_r($m);
        //print_r($_REQUEST);
        if ($_REQUEST['pawned'] == "")
        {
            try
            {
                if ($m->save() != FALSE)
                {
                    $tpl = new Template("./modules/member/view/childLine.tpl");
                    foreach ($m as $key => $value)
                    {
                        $tpl->set($key, $value);
                    }
                    $this->params['content'] = $tpl->output();
                }
                else
                {
                    throw new Exception();
                }
            }
            catch (Exception $e)
            {
                $this->params['content'] = "Kunne ikke lagre bruker: " . $e;
            }
        }
    }

    public function prepareMyDetails()
    {
        $this->obj = $this->member;
    }

    public function adminMenuItem()
    {
        $str = '<div id="newPasswordHeader" class="mHeader" onclick="displayAdminQuickPage(this)">Administrasjon</div>';

        if ($this->member->getMemberLevel() < 2)
            return $str;
        else
            return "";
    }

    public function prepareMembership()
    {
        $this->obj = new Member($this->controller->id);
        //print_r($this->obj);
        $hasMainMember = false;
        if ($this->obj->isParent)
        {

            $this->obj->loadChildren();

            if ($this->obj->getMemberType() == 1)
            {
                $hasMainMember = TRUE;
            }
            foreach ($this->obj->getChildren() as $children)
            {

                if ($children->getMemberType() == 1)
                {
                    $hasMainMember = TRUE;
                }
            }
        }
        else
        {
            $parent = new Member($this->obj->parentId);
            $parent->loadChildren();
            if ($parent->getMemberType() == 1)
            {
                $hasMainMember = TRUE;
            }
            foreach ($parent->getChildren() as $children)
            {
                if ($children->getMemberType() == 1)
                {
                    $hasMainMember = TRUE;
                }
            }
        }

        if ($hasMainMember)
        {
            $this->params['options'] = ' <option value="2">Husstandsmedlem</option>';
        }
        else
        {
            $this->params['options'] = '<option value="1">Ordinær medlem</option>';
        }
    }

    public function saveMemberShip()
    {

        $my = new MemberYear();


        $my->setPaid(0);
        $my->setYear(MemberYear::getCurrentYear());
        $my->setMemberId($this->controller->id);
        $my->setType($_REQUEST['type']);
        if ($my->save())
        {

            $this->params['content'] = "Medlemskap opprettet";
        }
        else
        {
            $this->params['content'] = "Opprettelse av medlemskap feilet";
        }
    }

    public function getBill()
    {
        $str = "";
        $price = 0;
        $rows = $this->member->getUnpaidMemberships();

        foreach ($rows as $row)
        {
            $tpl = new Template("./modules/member/view/billLine.tpl");
            $price += $row['price'];

            Member::markBillDate($row);
            foreach ($row as $key => $value)
            {
                $tpl->set($key, Helper::utf($value));
            }
            $str .= $tpl->output();
        }
        $this->params['price'] = $price;
        $this->params["rows"] = $str;
        $this->params['year'] = MemberYear::getCurrentYear();

        $date = strtotime("+2 week");
        $this->params["dueDate"] = date("d.m.Y", $date);
    }

    public function getCourses()
    {
        $this->params['content'] = $this->getMyCourses();
    }

    public function requestPassword()
    {
        $mail = $_REQUEST['mail'];
        $firstName = $_REQUEST['firstName'];

        $member = Member::getByMail($mail, $firstName);
        if ($member->getMemberId() == NULL || $member->getMemberId() == 0)
        {
            $this->params['content'] = "Finner ikke bruker. Ta kontakt med administrator av siden.";
        }
        else
        {
            $newpass = substr($member->getPassword(), 0, 8);

            $member->setPassword($newpass);
            $message = "Du, eller noen som kjenner din epost har bedt om nytt passord \n";
            $message .= "Ditt nye passord er: $newpass \n";
            $message .= "Vennlig hilsen medlemssystemet til EKTK :) ";


            $m = new Mail($mail, "noreply@egersundklatreklubb.com", $message, "Endring av passord EKTK");

            $m->fromName = "postmaster";
            $ms = $m->send();
            if ($ms)
            {
                if ($member->changePassword())
                {
                    $this->params['content'] = "Passordet ditt ble oppdatert";
                }
            }
        }

        //
    }

    public function resetMemberships()
    {
        $this->member = new Member($this->controller->id);

        $this->member->loadChildren();

        $this->member->deleteMembership();
        foreach ($this->member->getChildren() as $child)
        {
            $child->deleteMembership();
        }
        // print_r($this->member);
        $this->params['content'] = "Slettet....";
    }

    public function getMyCourses()
    {

        $str = "";

        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "select courseId from member_has_course where memberId = :mid;";

            //

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':mid', $this->member->memberId, PDO::PARAM_INT);

            $array = array();
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {

                $c = new Course($row['courseId']);
                $c->loadPartisipants();

                $array[] = $c;
            }
            foreach ($array as $co)
            {
                foreach ($co->getPartisipants() as $p)
                {
                    $status = "";
                    if ($p->getMemberId() == $this->member->memberId)
                    {
                        if ($p->getPaid() == 1)
                        {
                            $status = "Betalt";
                        }
                        else
                        {
                            $status = "Ikke-betalt";
                        }
                    }
                }
                $str .= "<div>" . $co->courseName . " Status: $status <button onclick='createCourseBill(" . $co->getCourseId() . ")'>Klikk for faktura </button>";

                $payPal = new PayPal();
                $payPal->setAmount($co->price);
                $payPal->itemName = "Kurs: " . $co->courseName;

                $token = $payPal->getToken();
                $_SESSION[urldecode($token)] = $co;

                $url = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=" . $token;
                $a = "<a href='$url'>Betal med kort (paypal)</a>";

                if ($this->member->memberlevel < 2)
                    $str .= $a;
                //$tpl = new Template("app/view/courses/paypalCourseForm.tpl");
                //$tpl->set("amount",$co->price);
                //$tpl->set("id",$co->courseId);
                //$str .= $tpl->output();
                $str .= "</div>";
            }
        }
        catch (PDOExeption $e)
        {

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

    public function prepareNewPassword()
    {
        
    }

    private function secureAdmin()
    {

        if (empty($_SESSION['member']))
        {
            die("Ikke tilgang!!");
        }

        if ($_SESSION['member']->getMemberLevel() > 2)
        {
            die("Ikke tilgang");
        }
    }

    public function getDueMemberList()
    {

        $this->secureAdmin();
        $year = MemberYear::getCurrentYear();
        $array = array();
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "select * from member me 
                    inner join memberYear my on me.memberId = my.member_memberId
                    inner join memberType mt on my.typeId = mt.typeId
                    where my.paid = 0 and `year` = :year";

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(":year", $year, PDO::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $m = new Member($row['memberId']);
                $array[] = $m;
            }
        }
        catch (PDOExeption $e)
        {
            return "Connection failed: " . $e->getMessage();
        }

        $str = "<h3>Ikke betalt:</h3>";
        $count = 1;

        foreach ($array as $key => $value)
        {
            $str .= "<div class='memberContainer' id=''> ";
            $str .= "<div> $count " . $value->firstName . " " . $value->lastName . "</div>";
            $count++;
            $str .= "</div>";
        }
        return $str;
    }

    public function getMemberList()
    {
        $this->secureAdmin();

        $array = array();

        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "select memberId from member  where isParent = TRUE ; ";
            //


            $stmt = $dbh->prepare($sql);


            $stmt->execute();


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {

                $m = new Member($row['memberId']);
                $m->loadChildren();

                $array[] = $m;
            }
        }
        catch (PDOExeption $e)
        {

            return "Connection failed: " . $e->getMessage();
        }

        $str = "";
        $count = 1;

        foreach ($array as $key => $value)
        {
            $str .= "<div class='memberContainer' id=''> ";
            $status = $value->getCurrentStatus();
            $length = count($status);
            $skipPayment = FALSE;
            if ($length < 2)
            {
                $currStat = "<span class='notMember inlineBlock'>Ikke medlem</span>";
                $skipPayment = TRUE;
            }
            else
            {
                $currStat = "<span class='member inlineBlock'>Medlem</span>";
            }
            if ($status['paid'] == 1)
            {
                $currStat .= " <span class='paid inlineBlock'>Betalt</span>";
            }
            elseif (!$skipPayment)
            {
                $currStat .= " <span id='payBtn_" . $value->memberId . "' title='klikk for å merke betalt'  class='notPaid inlineBlock'  onclick='registerPayment(" . $status['year'] . "," . $status['member_memberId'] . ",this)'>Ikke betalt.</span>";
            }
            if ($value->brattkortStatus == 1)
            {
                $bkStatus = "<span class='paid inlineBlock'>Har brattkort</span>";
            }
            else
            {
                $bkStatus = "<span id='cardBtn_" . $value->memberId . "' title='klikk for å merke med brattkort'  class='notPaid inlineBlock'  onclick='registerBrattkort(" . $value->memberId . ",this)'>Ikke brattkort.</span>";
            }

            $str .= "<div> <span class='inlineBlock parentSpan'>$count " . $value->firstName . " " . $value->lastName . " </span>$currStat $bkStatus</div>";
            $count++;

            foreach ($value->getChildren() as $child)
            {
                $status = $child->getCurrentStatus();
                
                $length = count($status);
                $skipPayment = FALSE;
                if ($length < 2)
                {
                    $currStat = "<span class='notMember inlineBlock'>Ikke medlem</span>";
                    $skipPayment = TRUE;
                }
                else
                {
                    $currStat = "<span class='member inlineBlock'>Medlem</span>";
                }
                if ($status['paid'] == 1)
                {
                    $currStat .= " <span class='paid inlineBlock'>Betalt</span>";
                }
                elseif (!$skipPayment)
                {
                    $currStat .= " <span id='payBtn_" . $child->memberId . "' title='klikk for å merke betalt' class='notPaid inlineBlock'  onclick='registerPayment(" . $status['year'] . "," . $child->memberId . ",this)'>Ikke betalt.</span>";
                }
                #Brattkort.. 
                
                if ($child->brattkortStatus == 1)
                {
                    $bkStatus = "<span class='paid inlineBlock'>Har brattkort</span>";
                }
                else
                {
                    $bkStatus = "<span id='cardBtn_" . $child->memberId . "' title='klikk for å merke brattkort'  class='notPaid inlineBlock'  onclick='registerBrattkort(" . $child->memberId . ",this)'>Ikke brattkort.</span>";
                }

                $str .= "<div class='childDiv'><span class='inlineBlock childSpan'> $count " . $child->firstName . " " . $child->lastName . " </span> $currStat $bkStatus</div>";

                $count++;
            }
            $str .= "</div>";
        }
        return $str;
    }

    public function numMembers()
    {
        $this->secureAdmin();
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "select count(*) as num from member ; ";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['num'];
        }
        catch (PDOExeption $e)
        {
            return "Connection failed: " . $e->getMessage();
        }
    }

    public function registerMemberPayment()
    {

        $this->secureAdmin();
        $mid = $_REQUEST['mid'];
        $year = $_REQUEST['year'];

        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "UPDATE memberYear SET `paid` = true WHERE member_memberId = :mid AND `year` = :year;";

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(":year", $year, PDO::PARAM_INT);
            $stmt->bindParam(":mid", $mid, PDO::PARAM_INT);
            $stmt->execute();
            $this->params['content'] = "true";
        }
        catch (PDOExeption $e)
        {
            $this->params['content'] = "false";
            return "Connection failed: " . $e->getMessage();
        }
    }

    public function registerBrattkort()
    {
        $this->secureAdmin();
        $mid = $_REQUEST['mid'];
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "UPDATE member SET `hasBrattkort` = 1 WHERE memberId = :mid;";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(":mid", $mid, PDO::PARAM_INT);
            $stmt->execute();
            $this->params['content'] = "true";
        }
        catch (PDOExeption $e)
        {
            $this->params['content'] = "false";
            return "Connection failed: " . $e->getMessage();
        }
    }
    public function getAdminButtons()
    {
        $this->secureAdmin();
        
        $tpl = new Template("./modules/member/view/adminButtons.tpl");
        return $tpl->output();
        
    }
    
    public function confirmAdmin()
    {
        $this->secureAdmin();
    }
}
