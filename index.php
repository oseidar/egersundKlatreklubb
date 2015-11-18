<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
ini_set('default_charset', 'UTF-8');

include_once 'configuration.php';
include_once './resources/library/Helper.php';
session_start();

//session_destroy();
if(empty($_REQUEST['ajax'])){
$router = new Router();

$controller = new Controller($router);
$controller->init();
$controller->loadControllers();
$controller->renderMain();

}
else{
    $ajax = new Ajax();
    
    $ajax->init();
    $ajax->loadControllers();
    if(empty($_REQUEST['json'])){
       echo  $ajax->registerModules();
    }
    else{
       echo  $ajax->registerModules(true);
    }
}
?>