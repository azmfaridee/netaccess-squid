<?php

    require_once('../conf/db.inc.php');
    require_once('../utils/class.Utility.php');
   
    session_start();
    
    try{
        $pdoConnection =  new PDO_connection();
        $conn = $pdoConnection->getConnection();
            
        $userid = $_SESSION['user']['userid'];
        //need to code check if the user already logout/kicked out code goes here......
            
        // update loglogin
        // $logouttime = date("Y-m-d H:i:s");
        $logouttime = Utility::getCurrentTimeStamp();
        $logouttype = "logout";
        $logintime = $_SESSION['user']['logintime'];
        $userip = $_SESSION['user']['userip'];
            
            
            
        //check if user already logout then dont override old login info
        $sql = "select count(*) from loglogin where userid='$userid' and logintime='$logintime' AND logouttime IS NULL";
        $resultSet = $conn->query($sql);
        if($resultSet->fetchColumn() > 0)
	{ 
            //need to implement transaction 
            $sql =  "update loglogin set logouttime='$logouttime', logouttype='$logouttype' where userid='$userid' and logintime='$logintime'";
            $conn->exec($sql);
        }
            
            
        $sql = "DELETE FROM loggedin WHERE ip='$userip'";
        $conn->exec($sql);
            
            
        //$sql = "insert into log values('$userid', 0, now())";
        //$conn->exec($sql);
            
        session_start();
        //session_unset();
	unset($_SESSION['user']);
        //session_destroy();
            
        header('location:index.php');
            
       } catch(PDOException $pe){
           echo $pe->getMessage();
       }

?>