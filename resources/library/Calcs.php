<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Calcs
 *
 * @author idar
 */
class Calcs {
    //put your code here
    public static function rowClass($nr){
        if($nr%2==0){
            return "even";
        }
        else{
            return "odd";
        }
    }
}
?>
