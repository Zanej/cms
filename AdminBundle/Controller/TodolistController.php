<?php
    namespace CMS\AdminBundle\Controller;
    use CMS\Controller\AbstractController; 
    class TodolistController extends AbstractController{
        function __construct(){
                parent::__construct('todolist');
        }
    }