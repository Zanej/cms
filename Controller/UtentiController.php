<?php
    namespace CMS\Controller;
    use CMS\DbWorkers\Table; 
    class UtentiController extends Table{
        function __construct(){
            parent::__construct('utenti');
        }
} ?>