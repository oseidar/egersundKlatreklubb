<?php

class Menu_controller extends CoreController
{
    public static function subMenuActivities()
    {
        
    }
    
    public static function subMenuMembership()
    {
         $tpl = new Template("modules/menu/view/subMenuMembership.tpl");
      
        return $tpl->output();
    }
    public static function subMenuArrangements()
    {
        
    }
    
    public static function subMenuContact()
    {

    }
    public static function menuItemLogInnOut()
    {   
        
        if(!array_key_exists("user", $_SESSION))
        {
            return;
        }
            
        
        if($_SESSION['user']->userId != 0)
        {   
            $tpl = new Template("modules/menu/view/userLogOut.tpl");
            return $tpl->output();
        }
    }

}

