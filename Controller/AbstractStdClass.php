<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CMS\Controller;

/**
 * Description of AbstractStdClass
 *
 * @author zane2
 */
class AbstractStdClass extends \stdClass{
    function __construct($params){
        foreach($params as $k => $v){
            $this->$k = $v;
        }
    }
    function get($what){
        return $this->$what;
    }
    function set($what){
        $this->$what = $what;
    }
    //put your code here
}
