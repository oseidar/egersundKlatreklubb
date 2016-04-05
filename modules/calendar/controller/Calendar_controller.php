<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Organization_controller extends CoreController
{
    public function createOrganization()
    {
        if(User::isValid())
        {
            $organization = new Organization(0);
            $this->params['feedback'] = $organization->save();
        }
    }
}