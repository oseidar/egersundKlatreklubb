<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author idar
 */
include_once 'Helper.php';

class Controller
{

    public $module, $action, $id, $view, $params, $lang, $uri;
    public $router;
    public $user;
    private $mainRender;

    function __construct($router)
    {

        $this->uri = $_SERVER['REQUEST_URI'];

        $this->router = new Router();
        $this->router = $router;
        @$this->module = $_REQUEST['module'];
        @$this->action = $_REQUEST['action'];
        @$this->view = $_REQUEST['view'];
        @$this->id = $_REQUEST['id'];
        if (!empty($_REQUEST['mainView']))
        {
            @$this->mainRender = "templates/default/" . $_REQUEST['mainView'] . ".tpl";
        }

        @$this->lang = $_REQUEST['lang'];
        if (empty($this->lang))
        {
            @$this->lang = $_SESSION['lang'];
        }
        if (empty($this->lang))
        {
            $this->lang = "no_nb";
        }
        $_SESSION['lang'] = $this->lang;

        if (get_magic_quotes_gpc())
        {
            $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
            while (list($key, $val) = each($process))
            {
                foreach ($val as $k => $v)
                {
                    unset($process[$key][$k]);
                    if (is_array($v))
                    {
                        $process[$key][stripslashes($k)] = $v;
                        $process[] = &$process[$key][stripslashes($k)];
                    }
                    else
                    {
                        $process[$key][stripslashes($k)] = stripslashes($v);
                    }
                }
            }
            unset($process);
        }

        foreach ($_POST as $key => $value)
        {

            if (!is_array($value))
            {
                $_POST[$key] = trim($_POST[$key]);
            }
        }
        $this->router->params['rightColumn'] = "";
        $this->router->params['footer'] = "<a style='text-decoration:none;font-size:12px' href='?module=user&action=login&view=loginForm&id='>copyright &copy; Magmageopark</a>";
        $this->router->params['topMenu'] = "<a href=''>Contact</a>";
    }

    public function init()
    {

        if (empty($_REQUEST['module']))
        {
            $this->router->params['title'] = "Forsiden";
        }

        $this->user = User::authenticate();
        if (!$this->user)
        {
            $this->user = new User(0);
            $this->user->setFirstName("John");
            $this->user->setLastName("Doe");
            $this->user->setUserlevel(6);
        }

        /*
         * Init av  params content
         * 
         */

        $this->router->params['content'] = "";

        try
        {
            $this->router->params['user'] = $this->user->getFirstName() . " " . $this->user->getLastName();
        }
        catch (Exception $e)
        {
            echo $e;
        }


        if (preg_match('/lang/', $this->uri) == 1)
        {
            $this->uri = substr($this->uri, 0, strlen($this->uri) - 11);
        }

        if (preg_match('/\?/', $this->uri) == 1)
        {



            $this->router->params['url'] = $this->uri . "&";
        }
        else
        {
            $this->router->params['url'] = $this->uri . "?";
        }
    }

    public function getMainRender()
    {
        return $this->mainRender;
    }

    public
            function setMainRender($mainRender)
    {
        $this->mainRender = $mainRender;
    }

    public
            function loadControllers()
    {
        if (!empty($this->module))
        {
            $file = 'modules/' . $this->module . "/controller/" . ucfirst($this->module) . '_controller.php';
            try
            {
                if (file_exists($file))
                {
                    include_once $file;
                }
                else
                {
                    throw new Exception();
                }
            }
            catch (Exception $e)
            {

                $this->router->params['content'] = "Kunne ikke laste kontroller... " . $e;
            }
        }
        else
        {
            // we load the frontpage... 
            include_once 'modules/frontpage/controller/Frontpage_controller.php';
        }
        include_once 'modules/menu/controller/Menu_controller.php';
    }

    public function buildMenu()
    {
        
    }

    public function checkUserAuth()
    {

        $user = User::authenticate();
        if (!empty($this->user))
        {
            $this->user = new User(0);
            $this->user->setFirstName("John");
            $this->user->setLastName("Doe");
            $this->user->setUserlevel(6);
        }
    }

    public
            function renderMain()
    {
        $mainTpl = "";

        $this->registerModules();
        $this->renderModules();
        /*
         * Hack for frontend admin menu...
         */
        $this->router->params['adminMenu'] = "";
        if ($this->user->userlevel < 2)
        {

            $menu = "<ul class='menuUl'>";
            $menu .= "<li><a style='color:#fff;text-shadow:0 0 3px #000;' href='?module=info&action=prepareAdmin&view=admin&id=' rel='#overlay' >Informasjon</a></li>";
            $menu .= "<li><a style='color:#fff;text-shadow:0 0 3px #000;' href='?module=menu&action=prepareAdmin&view=admin&id=' rel='#overlay'>Menuadmin</a></li>";
            $menu .= "<li><a style='color:#fff;text-shadow:0 0 3px #000;' href='?module=user&action=prepareAdmin&view=admin&id=' rel='#overlay'> Brukeradmin</a></li>";
            $menu .= "<li><a style='color:#fff;text-shadow:0 0 3px #000;' href='?module=funFact&action=prepareAdmin&view=admin&id=' rel='#overlay'> FunFacts</a></li>";
            $menu .= "<li><a style='color:#fff;text-shadow:0 0 3px #000;' href='?module=faq&action=prepareAdmin&view=admin&id=' rel='#overlay'> FAQ</a></li>";
            $menu .= "<li><a style='color:#fff;text-shadow:0 0 3px #000;' href='?module=traceLog&action=prepareAdmin&view=admin&id=' rel='#overlay'> traceLog</a></li>";
            $menu .= "<li><a style='color:#fff;text-shadow:0 0 3px #000;' href='/help/' >Hjelpefiler</a></li>";
            $menu .= "<li><a style='color:#fff;text-shadow:0 0 3px #000;' href='?module=user&action=logout&view=logout&id=' rel='#overlay'> Log out</a></li>";
            $menu .= "</ul>";
            $this->router->params["adminMenu"] = '<div id="adminMenu" style="position: fixed;z-index:10000; bottom: 0px; height: 35px; width: 100%; background: rgba(0, 0, 0, 0.2); color:#fff; border-top:1px solid #aaa;">' . $menu . '</div>';
        }
        //print_r($this->mainRender);
        if (isset($this->mainRender))
        {
            $mainTpl = $this->mainRender;
        }
        else
        {
            $mainTpl = "templates/default/default.tpl";
        }
        $template = new Template($mainTpl);
        $this->router->params['year'] = date("Y");
        if (empty($this->router->params['title']))
        {
            $this->router->params['title'] = Configuration::defaultTitle;
        }
        foreach ($this->router->params as $key => $value)
        {
            $template->set($key, $value);
        }

        echo $template->output();
    }

    public function registerModules()
    {

        //print_r("Kjøring av registerModules");
        /*
         * Starter alltid med å hente de første modulene... .
         */
        //echo "Username: + ".$this->user->username;


        if (empty($this->module))
        {
            // dersom vi ikke har moduler henter vi fremsiden... 

            $fp = new Frontpage_controller($this->user, $this);
            $this->router->params["content"] = $fp->render();
            $this->router->params["breadCrumbs"] = "Forsiden";
        }
        else
        {

            try
            {
                $classname = ucfirst($this->module) . "_controller";
                try
                {
                    if (class_exists($classname, false))
                    {

                        $m = new $classname($this->user, $this);

                        if (!empty($this->action))
                        {
                            if (method_exists($m, $this->action))
                            {

                                $method = $this->action;
                                $m->$method();

                                $this->router->params['content'] = $m->render();
                            }
                            else
                            {
                                throw new Exception();
                            }
                        }
                        else
                        {


                            $this->router->params['content'] = $m->render();
                        }
                    }
                    else
                    {
                        throw new Exception();
                    }
                }
                catch (Exception $e)
                {
                    $this->router->params['content'] .= "Kunne ikke laste klasse: " . $e->getMessage();
                }
            }
            catch (Exception $e)
            {
                $this->router->params['content'] .= "Kunne ikke laste modul: " . $e->getMessage();
            }
        }

        /*
         * Correcting missing user after logout
         */
        if (empty($this->user))
        {
            $this->user = new User(0);
            $this->user->setFirstName("John");
            $this->user->setLastName("Doe");
            $this->user->setUserlevel(6);
        }
        //print_r($this->user);
        $mc = new Menu_controller($this->user, $this);

        $mc->setTplFile("modules/menu/view/default.tpl");

        $this->router->params["menu"] = $mc->render();

        //adding script and css
        $this->router->params['moduleScript'] = "<script type='text/javascript' src='" . Configuration::baseUrl . "/modules/" . $_REQUEST['module'] . "/js/script.js'></script>";
        $this->router->params['moduleCss'] = "<link type='text/css' rel='stylesheet' href='" . Configuration::baseUrl . "/modules/" . $_REQUEST["module"] . "/css/style.css' />";
    }

    private function renderModules()
    {
        
    }

}
