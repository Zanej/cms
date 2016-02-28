<?php
    namespace CMS\Controller;
    use CMS\DbWorkers\Table; 
    class AgenzieController extends Table{
        function __construct(){
            parent::__construct('agenzie');
        }
} ?>