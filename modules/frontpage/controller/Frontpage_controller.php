<?php
class Frontpage_controller extends CoreController
{
    function __construct($user, $controller)
    {
        parent::__construct($user, $controller);
        

        
        
    }

    public static function displayContactInfo()
    {
        $tpl = new Template("./modules/frontpage/view/contactInfo.tpl");
        return $tpl->output();
    }
    
    public static function displayCalendar()
    {
        $tpl2 = new Template("./modules/frontpage/view/frontPageCalendar.tpl");
        $this->params['calendar'] = $tpl2->output();
    }
    
    public static function displayFrontpageNews()
    {
        
    }
}

