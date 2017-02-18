<?php
    namespace CMS\TaskBundle\Controller;
    use CMS\Controller\AbstractController; 
    use CMS\TaskBundle\Controller\Cms_langController as Trad;
    use CMS\DbWorkers\QueryBuilder as QB;
    use CMS\Conf\Config as Conf;

    class Task_usersController extends AbstractController{
        function __construct(){
            parent::__construct('task_users');
        }
        static function isUserLogged(){
            if(!isset($_COOKIE["task_user"])){
                return false;
            }else{
                $user = explode("|",$_COOKIE["task_user"]);
                $db = Conf::getDB();
                
                $res = $db->Query("SELECT id FROM task_users WHERE md5(username)='".$user[0]."' AND password='".$user[1]."' LIMIT 1");                
                if(!$res){
                    return false;
                }
                return true;
            }
        }

        public function getUserLogged(){
            if(!self::isUserLogged()){
                return false;
            }
            $user = explode("|",$_COOKIE["task_user"]);
            $username = $user[0];            
            $user = $this->findBy(array("md5(username)"=>$username),false,"*",1);
            return $user[0];
        }

        public function loginAction(){            
            return $this->render("task/login");
        }
        
        public function indexAction($type){

            $trad = new Trad();

        	return $this->render("task/index",array("user"=>$this->getUserLogged(),"type"=>$type,"trad"=>$trad));
        }

        static function exists(){
            
            if(!isset($_POST["username"]) || !isset($_POST["password"])){
                return false;
            }
            
            $qb = new QB();            
            $res = $qb->select("task_users", "id", array("username"=>$_POST["username"],"password"=>md5($_POST["password"])))->getResult(false);                            
            if(is_array($res)){
                return true;
            }else{
                $_SESSION["msg"] = "Login fallito";
                return false;
            }            
        }        
    }