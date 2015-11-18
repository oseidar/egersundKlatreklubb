<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Container
 *
 * @author idar
 */
class Container {
    
    public static function roundedCornerBox($content){
        
        return "<div class='widget greyBorder padding10 roundedCorner4'>$content</div>";
        
    }
    
    public static function squareCornerBox($content){
        
        return "<div class='widget greyBorder padding10 '>$content</div>";
        
    }
    
    public static function noBorderBox($content){
        return "<div class='widget padding10'>$content</div>";
    }
    
    public static function titledBox($title,$content){
        $t = "<div class='boxTitle'><h4>$title</h4></div>";
        $body =  "<div class='padding10'>$content</div>";
        return "<div class='widget greyBorder'>$t $body</div>";
    }
    
    public static function titledRoundedBox($title,$content){
        $t = "<div class='boxTitle'><h4>$title</h4></div>";
        $body =  "<div class='padding10'>$content</div>";
        return "<div class='widget roundedCorner4 greyBorder'>$t $body</div>";
    }
}

?>
