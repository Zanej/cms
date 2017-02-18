<?php
    namespace CMS\TaskBundle\Controller;
    use CMS\Controller\AbstractController; 
    use CMS\TaskBundle\Controller\Task_usersController;
    use CMS\TaskBundle\Controller\Cms_langController as Trad;

    class TaskController extends AbstractController{

        function __construct(){
                parent::__construct('task');
        }

        public function indexAction($week="",$month="",$year="",$type=""){	  

	        $user = new Task_usersController();            

	        $username = $user->getUserLogged();	        

            $trad = new Trad();

            if(!$type){

                if(isset($_SESSION["task_type"])){

                    $type = $_SESSION["task_type"];
                }else{

                    $_SESSION["task_type"] = "weekly";
                    $type =" weekly";
                }
            }else{

                $_SESSION["task_type"] = $type;
            }

            if(!$week && !$month && !$year){

                $start = time();

            }elseif($week){

                echo $week;

                if($year){

                }else{

                    $this_week = date("W");
                    $diff = $week - $this_week;
                    $start = strtotime($diff." weeks");    
                }
                

            }

            if(date('w') == 1){

                $date_from = date("Y-m-d",$start);

            }else{

                $date_from = date("Y-m-d",strtotime("last monday",$start));
            }

            if(date('w') == 0){

                $date_to = date("Y-m-d"); 
            }else{

                $date_to = date("Y-m-d",strtotime("next sunday",$start));     
            }
                
            

            
            if($type == "daily"){
                $tasks = $this->findBy(array("date >= '$date_from'","date <= '$date_to'"),false);
                
                #print_r($tasks);

                #echo date("Y-m-d",strtotime("42 week"));

                $days = array();

                for($i=0;$i<=6;$i++){

                    $day["date"] = date("Y-m-d",strtotime("+ ".$i." day",strtotime($date_from)));
                    $day["name"] = Trad::gsl(date("l",strtotime($day["date"])),"giorni");                    
                    $days[$day["date"]] = $day;
                }                

                foreach($tasks as $k => $v){

                    $days[$v->getDate()]["tasks"][] = $v;
                }
                
                /*echo "<pre>";
                    print_r($days);
                echo "</pre>";

                exit;*/
            }
            
            

	        return $this->render("task/index",array("user"=>$username,"type"=>$type,"days"=>$days,"trad"=>$trad));
    	}
    }

