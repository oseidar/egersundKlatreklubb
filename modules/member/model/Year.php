<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Year
 *
 * @author idar
 */
class Year {
    
    public static function getYear()
    {
        try
        {
            $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $sql = "SELECT year FROM yearPrice order by year desc limit 1;";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['year'];
        }
        catch(PDOExeption $e)
        {
            return FALSE;
        }
    }
}

?>
