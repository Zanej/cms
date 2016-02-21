<?php
namespace CMS\DbWorkers;
error_reporting(E_ERROR);

if(!isset($_FILES)) $_FILES = $HTTP_POST_FILES;
if(!isset($_SERVER)) $_SERVER = $HTTP_SERVER_VARS;
if(!isset($_SESSION)) $_SESSION = $HTTP_SESSION_VARS;
if(!isset($_POST)) $_POST = $HTTP_POST_VARS;
if(!isset($_GET)) $_GET = $HTTP_GET_VARS;

if( $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ){
	
	#echo "LAVORO LOCALE";
	 /*define("DB_HOST", '192.168.0.15');
    define("DB_USER", 'sil_booking');
    define("DB_PASSWORD", 'lignano');
    define("DB_NAME", 'kicero' );*/
   define("DB_HOST","127.0.0.1");
   define("DB_USER","root");
   define("DB_PASSWORD","");
   define("DB_NAME","test");

}else{
	
	

}

define("VAT_VALUE", 22 );
define("VAT_VALUE_X", 1.22 );

//require_once dirname(__FILE__).'/config.inc.php';
require_once dirname(__FILE__).'/db.class.inc.php';
#require_once dirname(__FILE__).'/ezmc.class.inc.php';

$db = new MySQL(true, DB_NAME, DB_HOST, DB_USER, DB_PASSWORD);
//print_r($db);
if( $db->Error() )
	$db->Kill("Errore connessione a DB");

?>