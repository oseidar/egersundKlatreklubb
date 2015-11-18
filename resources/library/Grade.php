<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grade
 *
 * @author idar
 */
class Grade {
    //put your code here
    private $climb;
    
    private $ascent;
    private $user;
    public  static   $boulderGrades = array("n/a","0","0","0","0","0","3","4","4+","5","5+","6A","6A+","6B","6B+","6C","6C+","7A","7A+","7B","7B+","7C","7C+","8A","8A+","8B","8B+","8C","8C+");
    public  static   $routeGrades  =  array("n/a","3","3+","4","4+","5a","5b", "5c", "6a","6a+","6b","6b+","6c","6c+","7a","7a+","7b","7b+","7c","7c+","8a","8a+","8b","8b+","8c","8c+","9a","9a+","9b","9b+");
    public  static   $norwegianRouteGrades  =  array("n/a","3","3+","4","4+","5-","5", "5+", "6-","6","6+","7-","7-/7","7","7+","7+/8-","8-","8","8/8+","8+","9-","9-/9","9","9/9+","9+","9+/10-","10-","10-/10","10","10/10+");




    public function __construct() {

    }
    public function getClimb() {
        return $this->climb;
    }

    public function setClimb($climb) {
        $this->climb = $climb;
    }

    public function getAscent() {
        return $this->ascent;
    }

    public function setAscent($ascent) {
        $this->ascent = $ascent;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getCommunityGrade(){

    }
    public function getTopoGrade(){
        //return $this->climb->

    }
    public function getPersonalGrade(){

        return $boulderGrades[$this->ascent->getSuggestGrade()];

    }
    public static function  convertNrToGrade($nr,$isRoute){
        $grade = "";
        if($isRoute){
            $grade = $routeGrades[$nr];
        }
        else{
            $grade = $boulderGrades[$nr];
        }
        return $grade;

    }
    
    public static function getBoulderGrade($grade){
        
        if($grade == -1){
            return "n/a";
            
        }
        return self::$boulderGrades[$grade];
                
        
    }

}
?>
