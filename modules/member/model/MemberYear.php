<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MemberYear
 *
 * @author idar
 */
class MemberYear
{

    public $year, $memberId, $type;
    public $paid;

    function __construct()
    {
        
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getMemberId()
    {
        return $this->memberId;
    }

    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getPaid()
    {
        return $this->paid;
    }

    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    public function save()
    {
        try
        {
            $dbh = new PDO(Configuration::dbUrl, Configuration::dbUser, Configuration::dbPass, array(PDO::ATTR_PERSISTENT => true));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "INSERT INTO memberYear (member_memberId, `year`, paid, typeId) VALUES (:mid, :year, false, :type);";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':mid', $this->memberId, PDO::PARAM_INT);
            $stmt->bindParam(':year', $this->year, PDO::PARAM_INT);
            $stmt->bindParam(':type', $this->type, PDO::PARAM_INT);
            $stmt->execute();

            return TRUE;
        }
        catch (PDOExeption $e)
        {

            return FALSE;
        }
    }

    public static function getCurrentYear()
    {
        return Year::getYear();
    }

}

?>
