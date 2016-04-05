<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$key = "f9253dcd4dac5f1ab579b571fa2de0cb7e03f08529df09eb047b12472920104fcf36df1d046faa6e3bbcee251fd03a35a7146ecb1de2863b724222a877438d0d";

$keyFromRequest = $_GET['key'];

if($keyFromRequest == $key)
{
    echo "TRUE";
}
else
{
    echo "FALSE";
}