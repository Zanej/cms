<?php
    namespace CMS\CacheBundle\Controller;
    use CMS\Controller\AbstractController; 
    class CacheController extends AbstractController{
        function __construct(){
            parent::__construct('cache');
        }
} ?>