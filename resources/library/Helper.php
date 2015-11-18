<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Helper
 *
 * @author idar
 */
class Helper {
    //put your code here
    
    
    public static function   printToChromeConsole($string){
        return "<script type='text/javascript'>console.log(\"".$string."\")</script>";
}

public static function triphoto_getGPS($fileName, $assoc = true)
{
    //get the EXIF
    $exif = exif_read_data($fileName);

    //get the Hemisphere multiplier
    $LatM = 1; $LongM = 1;
    if($exif["GPSLatitudeRef"] == 'S')
    {
    $LatM = -1;
    }
    if($exif["GPSLongitudeRef"] == 'W')
    {
    $LongM = -1;
    }

    //get the GPS data
    $gps['LatDegree']=$exif["GPSLatitude"][0];
    $gps['LatMinute']=$exif["GPSLatitude"][1];
    $gps['LatgSeconds']=$exif["GPSLatitude"][2];
    $gps['LongDegree']=$exif["GPSLongitude"][0];
    $gps['LongMinute']=$exif["GPSLongitude"][1];
    $gps['LongSeconds']=$exif["GPSLongitude"][2];

    //convert strings to numbers
    foreach($gps as $key => $value)
    {
    $pos = strpos($value, '/');
    if($pos !== false)
    {
        $temp = explode('/',$value);
        $gps[$key] = $temp[0] / $temp[1];
    }
    }

    //calculate the decimal degree
    $result['latitude'] = $LatM * ($gps['LatDegree'] + ($gps['LatMinute'] / 60) + ($gps['LatgSeconds'] / 3600));
    $result['longitude'] = $LongM * ($gps['LongDegree'] + ($gps['LongMinute'] / 60) + ($gps['LongSeconds'] / 3600));

    if($assoc)
    {
    return $result;
    }

    return json_encode($result);

    
    }
    public static function autoRotateImage($image) {
    $orientation = $image->getImageOrientation();

    switch($orientation) {
        case imagick::ORIENTATION_BOTTOMRIGHT: 
            $image->rotateimage("#000", 180); // rotate 180 degrees
        break;

        case imagick::ORIENTATION_RIGHTTOP:
            $image->rotateimage("#000", 90); // rotate 90 degrees CW
        break;

        case imagick::ORIENTATION_LEFTBOTTOM: 
            $image->rotateimage("#000", -90); // rotate 90 degrees CCW
        break;
    }

    // Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
    $image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
    
    return $image;
}

    public static function utf($str){
   //echo  mb_detect_encoding($str,'UTF-8');
    if(mb_detect_encoding($str,'UTF-8') == "UTF-8"){
           //echo "if utf-8";
          }
          else{
                 //echo "ikke utf-8";
               $str = utf8_encode($str);
          }
    return $str;
}
public static function traceLog(){
    //print_r($_SESSION);
    
    $userID = $_SESSION['user']->userId;
    $action = $_REQUEST['action'];
    
    try{
        $dbh = new PDO(Configuration::dbUrl,Configuration::dbUser,Configuration::dbPass,array( PDO::ATTR_PERSISTENT => true));
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

               $sql = "INSERT INTO traceLog (userId, action) VALUES (:userId, :action); ";
                

                $stmt = $dbh->prepare($sql);
                
                $stmt->bindParam(':userId',$userID,PDO::PARAM_INT);
                $stmt->bindParam(':action',$action,PDO::PARAM_STR);
                
               

                $stmt->execute();
               
                    
    }
    catch (PDOException $e){
     
        
    }
    
    
}
public static function curPageURL() {
 $pageURL = 'http';
 //if($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
    
}
function __autoload($classname) {
    
    try{
        $filename = "./resources/library/". $classname .".php";
        @include_once($filename);
    }
    catch(Exception $e){
        
    }
    try{
            @$module=$_GET['module'];
            $filename = "./modules/$module/model/". $classname .".php";
            @include_once($filename);
        }catch(Exception $ex){
            die($e ."<br> ".$ex);
        }
    
   
}

?>