<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class News
{
    public $newsId, $createDate, $publishDate, $removeDate, $category, $alias, $title, $ingress, $newsBody, $authorId, $published, $archive, $trash;
    
     function __construct($newsId)
    {
        $this->newsId = $newsId;
        
        if($this->newsId != 0)
        {
            //TODO: load news
        }
    }
}