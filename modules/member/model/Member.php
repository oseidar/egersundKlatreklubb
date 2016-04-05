<?php

/*
 * Core memberclass. Loaded at startup. 
 */

/**
 * Description of member
 *
 * @author idar
 */
class Member
{

    public $memberId, $password, $email, $firstName, $lastName, $memberlevel, $parentId, $active, $phone, $birthDate, $club, $zip, $adress, $isParent, $brattkortStatus;
    private $children = array();
    protected $parent;

    function __construct($memberId)
    {
        $this->memberId = $memberId;

        if ($this->memberId != 0)
        {
            try
            {
                $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "select * from `member` where memberId = :id ;";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':id', $this->memberId, PDO::PARAM_INT);


                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->firstName = Helper::utf($row['firstName']);

                $this->lastName = Helper::utf($row['lastName']);
                $this->brattkortStatus = $row['hasBrattkort'];
                $this->memberlevel = $row['memberlevel'];
                $this->club = $row['club'];
                $this->password = $row['password'];
                $this->birthDate = $row['bDate'];
                $this->phone = $row['phone'];
                $this->email = $row['mail'];
                $this->zip = $row['zip'];
                $this->adress = Helper::utf($row['adress']);
                $this->parentId = $row['parentId'];
                if ($row['isParent'] == 1)
                {
                    $this->isParent = TRUE;
                }
                else
                {
                    $this->isParent = FALSE;
                }
                if ($row['active'] == 1)
                {
                    $this->active = TRUE;
                }
                else
                {
                    $this->active = false;
                }
            }
            catch (PDOExeption $e)
            {

                die("Kunne ikke  laste Bruker: " . $e);
            }
        }
    }

    public function save()
    {

//print_r($this);
        if ($this->memberId == 0 || empty($this->memberId))
        {
            if ($this->parent == NULL)
            {
                $pid = 0;
            }
            else
            {
                $pid = $this->parent->memberId;
            }
            if (empty($this->password))
            {
                $this->password = md5($this->firstName . $this->birthDate);
            }
            try
            {
                $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "INSERT INTO  `member` ( firstName, lastName,adress , phone, club ,password, mail, parentId, isParent , zip, bDate, memberlevel) 
                                            VALUES ( :firstName, :lastName, :adress,:phone,:club , :password,:mail , :parentId , :isParent , :zip , :bDate, 5);";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':firstName', $this->firstName, PDO::PARAM_STR);
                $stmt->bindParam(':lastName', $this->lastName, PDO::PARAM_STR);
                $stmt->bindParam(':adress', $this->adress, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $this->phone, PDO::PARAM_STR);
                $stmt->bindParam(':club', $this->club, PDO::PARAM_STR);
                $stmt->bindParam(":bDate", $this->birthDate, PDO::PARAM_BOOL);
                $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
                $stmt->bindParam(':mail', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':parentId', $pid, PDO::PARAM_INT);
                $stmt->bindParam(':isParent', $this->isParent, PDO::PARAM_BOOL);
                $stmt->bindParam(':zip', $this->zip, PDO::PARAM_INT);
                $stmt->execute();
                return "Bruker lagret"; //Language::_savingTickOk;
            }
            catch (PDOExeption $e)
            {
                return false;
            }
        }
        else
        {

            try
            {
                $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "UPDATE  `member` SET firstName = :firstName, lastName = :lastName, bDate = :bDate, zip = :zip ,mail= :mail, club = :club , phone = :phone WHERE memberId = :uid LIMIT 1 ;";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':firstName', $this->firstName, PDO::PARAM_STR);
                $stmt->bindParam(':lastName', $this->lastName, PDO::PARAM_STR);
                $stmt->bindParam(':bDate', $this->birthDate, PDO::PARAM_STR);
                $stmt->bindParam(':mail', $this->email, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $this->phone, PDO::PARAM_STR);
                $stmt->bindParam(':club', $this->club, PDO::PARAM_STR);
                $stmt->bindParam(':uid', $this->memberId, PDO::PARAM_INT);
                $stmt->bindParam(':zip', $this->zip, PDO::PARAM_INT);
                $stmt->execute();
                print_r($this);
                return "Bruker lagret"; //Language::_savingTickOk;
            }
            catch (PDOExeption $e)
            {
                return false;
            }
        }
    }

    public function changePassword()
    {
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "UPDATE `member` SET password = :password WHERE memberId = :uid LIMIT 1 ;";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->memberId, PDO::PARAM_INT);
            $stmt->execute();
            return TRUE; //Language::_savingTickOk;
        }
        catch (PDOExeption $e)
        {

            return false;
        }
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    public function getClub()
    {
        return $this->club;
    }

    public function setClub($club)
    {
        $this->club = $club;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren($children)
    {
        $this->children = $children;
    }

    public function getGuestbookNic()
    {
        return $this->guestbookNic;
    }

    public function setGuestbookNic($guestbookNic)
    {
        $this->guestbookNic = $guestbookNic;
    }

    public function getMemberId()
    {
        return $this->memberId;
    }

    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getmemberlevel()
    {
        return $this->memberlevel;
    }

    public function setmemberlevel($memberlevel)
    {
        $this->memberlevel = $memberlevel;
    }

    public function getFullName()
    {

        return $this->firstName . " " . $this->lastName;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    public function getAdress()
    {
        return $this->adress;
    }

    public function setAdress($adress)
    {
        $this->adress = $adress;
    }

    public static function authenticate()
    {

        $member = new Member(0);
        if (empty($_SESSION['member']) && !empty($_REQUEST['mail']) && !empty($_REQUEST['password']))
        {
            $email = $_REQUEST['mail'];
            //echo "<h1> mail: $email</h1>";
            $password = $_REQUEST['password'];

            $member->setEmail($email);
            $member->setPassword($password);
            try
            {
                $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "select *,count(*)as nr   from `member` where mail = :mail && password = :password ;";

                //

                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':mail', $member->email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $member->password, PDO::PARAM_STR);

                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                //print_r($row);
                if ($row['nr'] == 1)
                {
                    $dbh2 = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass);
                    $dbh2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                    $sql2 = "select *  from `member` where mail = :mail && password = :password ;";

                    $stmt2 = $dbh2->prepare($sql2);
                    $stmt2->bindParam(':mail', $member->email, PDO::PARAM_STR);
                    $stmt2->bindParam(':password', $member->password, PDO::PARAM_STR);

                    $stmt2->execute();
                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                    //print_r($row2);

                    $member->firstName = $row2['firstName'];
                    $member->memberId = $row2['memberId'];

                    $member->lastName = $row2['lastName'];
                    $member->memberlevel = $row2['memberlevel'];
                    $member->adress = $row2['adress'];
                    $member->birthDate = $row2['bDate'];

                    $member->club = $row2['club'];
                    $member->password = $row2['password'];

                    $member->email = $row2['mail'];
                    $member->zip = $row2['zip'];
                    $member->phone = $row2['phone'];
                    /*
                     * secure utf8 encoding... 
                     */
                    foreach ($member as $key => $value)
                    {
                        if (gettype($value) == "string")
                        {
                            if (mb_detect_encoding($value, "auto") == "UTF-8")
                            {
                                $set = "set" . ucfirst($key);
                                $member->$set(utf8_encode($value));
                            }
                        }
                    }

                    //print_r($member);
                    $_SESSION['member'] = $member;
                }
                else
                {
                    $member->firstName = "John";
                    $member->password = "";
                    $member->memberlevel = 6;
                    $member->lastName = "Doe";
                    $member->guestbookNic = "guest";
                }

                return $member;
            }
            catch (PDOExeption $e)
            {

                echo "Kunne ikke  laste Bruker: " . $e;
            }
        }
        elseif (!empty($_SESSION['member']))
        {
            return $_SESSION['member'];
        }
        else
        {

            return false;
        }
    }

    public static function memberToUrl($var)
    {
        //print_r($var);
        $str = $var;
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = 'select u.*, concat_ws( " ",firstname,lastname) as `name` from buldreinfo.`member` u where concat_ws(" ",firstname,lastname) = :name ;';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':name', $var, PDO::PARAM_INT);
            $stmt->execute();
            $nr = $stmt->rowCount();

            if ($nr == 1)
            {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                //print_r("Ett treff");
                $str = "<a href='index.php?module=member&action=&view=viewmember&id=" . $row['memberId'] . "'>" . $row['name'] . "</a>";
            }
            else
            {
                $str = $var;
                // print_r($str);
            }
        }
        catch (PDOExeption $e)
        {

            echo ("Kunne ikke  laste Bruker: " . $e);
        }

        return $str;
    }

    public function getNumComments()
    {
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = 'SELECT count(*) as num from gjestebok where memberId = :id';

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $this->memberId, PDO::PARAM_INT);

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['num'];
        }
        catch (PDOExeption $e)
        {

            return "Kunne ikke  laste brukerdata: " . $e;
        }
    }

    public function loadChildren()
    {
        $array = array();


        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "select * from member where parentId = :id and active = TRUE; ";

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $this->memberId, PDO::PARAM_STR);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $tmp = new Member($row['memberId']);
                $array[] = $tmp;
            }
        }
        catch (PDOExeption $e)
        {

            return "Connection failed: " . $e->getMessage();
        }

        $this->children = $array;
    }

    public function getCurrentStatus()
    {
        $year = Year::getYear();
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = 'select * from memberYear my inner join memberType mt on my.typeId = mt.typeId where member_memberId  =  :id && `year` = :year ';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $this->memberId, PDO::PARAM_INT);
            $stmt->bindParam(":year", $year, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        catch (PDOExeption $e)
        {

            return "Kunne ikke  laste brukerdata: " . $e;
        }
    }

    public function getNumImages()
    {
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = 'SELECT count(*) as num from media where memberId = :id';
            $stmt = $dbh->prepare($sql);

            $stmt->bindParam(':id', $this->memberId, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['num'];
        }
        catch (PDOExeption $e)
        {
            return "Kunne ikke  laste brukerdata: " . $e;
        }
    }

    public function getNumFa()
    {
        $name = $this->getFullName();
        $name = "%" . $name . "%";
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = 'SELECT count(*) as num from problemer where FA LIKE :id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $name, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['num'];
        }
        catch (PDOExeption $e)
        {

            return "Kunne ikke  laste brukerdata: " . $e;
        }
    }

    public static function test()
    {
        return "dette er en test... ";
    }
    
    public function hasWallAccess()
    {   
        $year = MemberYear::getCurrentYear();
        
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = 'SELECT count(*) as nr FROM member m where m.hasBrattkort = TRUE AND m.memberId = :memberId AND '
                    . '(SELECT count(*) FROM memberYear WHERE member_memberId = :memberId AND paid = TRUE AND `year` = :year ) ;';

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':memberId', $this->memberId, PDO::PARAM_INT);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['nr'];
        }
        catch (PDOExeption $e)
        {

            return "Kunne ikke  laste brukerdata: " . $e;
        }
    }

    public function getNonMembers($year)
    {
        $array = array();

        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = 'select memberId from  member me  
                    where not exists(Select * from  memberYear my where me.memberId = my.member_memberId AND my.`year` = :year) and (parentId = :pid OR memberId = :pid );';

            $stmt = $dbh->prepare($sql);

            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':pid', $this->memberId, PDO::PARAM_INT);



            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $m = new Member($row['memberId']);
                $array[] = $m;
            }
            return $array;

            //print_r($nr);
        }
        catch (PDOExeption $e)
        {

            return "Kunne ikke  laste brukerdata: " . $e;
        }
    }

    public function getMemberType()
    {
        $isMain = false;
        $year = Year::getYear();
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = 'select my.typeId from  memberYear my inner join  member m on m.memberId = my.member_memberId where m.memberId = :mid and my.`year` = :year ;';

            $stmt = $dbh->prepare($sql);

            $stmt->bindParam(':mid', $this->memberId, PDO::PARAM_INT);
            $stmt->bindParam(":year", $year, 2);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //print_r($row);
            if (isset($row['typeId']))
            {

                return $row['typeId'];
            }
            else
            {
                return -1;
            }
        }
        catch (PDOExeption $e)
        {

            return "Kunne ikke  laste brukerdata: " . $e;
        }
    }

    public function getUnpaidMemberships()
    {
        $array = array();
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = 'select my.*,yp.price, mt.title, me.* from  memberYear my 
                        inner join  memberType mt on my.typeId = mt.typeId 
                        inner join  member me on my.member_memberId = me.memberId
                        inner join  yearPrice  yp on my.`year` = yp.`year` and my.typeId = yp.typeId
                        where my.paid = 0 AND (me.memberId = :mid OR me.parentId = :mid);';

            $stmt = $dbh->prepare($sql);

            $stmt->bindParam(':mid', $this->memberId, PDO::PARAM_INT);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $array[] = $row;
            }
            return $array;
        }
        catch (PDOExeption $e)
        {
            return "Kunne ikke  laste brukerdata: " . $e;
        }
    }

    public static function checkMail($mail)
    {
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = 'select count(*) as num from  member where mail = :mail ';

            $stmt = $dbh->prepare($sql);

            $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);


            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['num'];
        }
        catch (PDOExeption $e)
        {

            return "Kunne ikke  laste brukerdata: " . $e;
        }
    }

    public static function getByMail($mail, $fname)
    {
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "select * from `member` where mail = :mail AND firstName = :firstName ;";

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':firstName', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);


            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $m = new Member(0);
            $m->setMemberId($row['memberId']);
            $m->firstName = Helper::utf($row['firstName']);

            $m->lastName = Helper::utf($row['lastName']);
            $m->memberlevel = $row['memberlevel'];
            $m->club = $row['club'];
            $m->password = $row['password'];
            $m->birthDate = $row['bDate'];
            $m->phone = $row['phone'];
            $m->email = $row['mail'];
            $m->zip = $row['zip'];
            $m->adress = Helper::utf($row['adress']);
            $m->parent = $row['parentId'];
            if ($row['active'] == 1)
            {
                $m->active = TRUE;
            }
            else
            {
                $m->active = false;
            }

            return $m;
        }
        catch (PDOExeption $e)
        {

            die("Kunne ikke  laste Bruker: " . $e);
        }
    }

    public function deleteMembership()
    {   
        $year = MemberYear::getCurrentYear();
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "DELETE FROM memberYear WHERE member_memberId = :id AND `year` = :year AND paid = FALSE;";
            
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $this->memberId, PDO::PARAM_INT);
            $stmt->bindParam(":year", $year, PDO::PARAM_STR);
            $stmt->execute();
        }
        catch (PDOExeption $e)
        {

            die("Kunne ikke  laste Bruker: " . $e);
        }
    }
    
    public function delete()
    {
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "DELETE FROM member WHERE memberId = :id;";

            //
            
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $this->memberId, PDO::PARAM_INT);
            $stmt->execute();
            return TRUE;
        }
        catch (PDOExeption $e)
        {

           return FALSE;
        }
    }

    public static function markBillDate($row)
    {
        //print_r($row);
        $date = date("Y-m-d");
        $update = FALSE;
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "select invoiceDate from memberYear where member_memberId = :id AND `year` = :year;";

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $row["member_menberId"], PDO::PARAM_INT);
            $stmt->bindParam(":year", $row["year"], PDO::PARAM_STR);


            $stmt->execute();
            $check = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($check['invoiceDate'] == NULL || empty($check['invoiceDate']))
            {
                $update = TRUE;
            }
        }
        catch (PDOExeption $e)
        {

            die("Kunne ikke  laste Bruker: " . $e);
        }
        if ($update == TRUE)
        {

            try
            {
                $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

                $sql = "UPDATE memberYear SET `invoiceDate` = :date WHERE member_memberId = :id AND `year` = :year;";

                //

                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':id', $row["member_memberId"], PDO::PARAM_INT);
                $stmt->bindParam(":year", $row["year"], PDO::PARAM_STR);
                $stmt->bindParam(":date", $date, PDO::PARAM_STR);


                $stmt->execute();
            }
            catch (PDOExeption $e)
            {

                die("Kunne ikke  laste Bruker: " . $e);
            }
        }
    }

}

?>
