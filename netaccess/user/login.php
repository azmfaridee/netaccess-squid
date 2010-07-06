<?php

    session_start();
    require_once('../conf/db.inc.php');
    require_once('../utils/class.Utility.php');
  
    /*
    $pdoConnectionLoginCheck =  new PDO_connection();
    $connLoginCheck = $pdoConnectionLoginCheck->getConnection();
        
    $userLoginStatus = 0;
       
    if(isset($_SESSION['user']['userid']))
    {
        $userid = $_SESSION['user']['userid'];
        $query = "select count(*) from loggedin where userid='$userid'";
        $userLoginStatus = $connLoginCheck->query($query)->fetchColumn();
    }
        
    //close the connection
    $pdoConnectionLoginCheck = null;
    */
    
    
    if(isset($_SESSION['user']['userid']) && isset($_SESSION['user']['logged_in']) && ($_SESSION['user']['logged_in'] == true) && ($userLoginStatus > 0) )
    {
        include('userpanel.php');
    }
    else
    {
    
      try{
            $pdoConnection =  new PDO_connection();
            $conn = $pdoConnection->getConnection();    
        
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            
            $password = md5($password);
            //$userip = getenv("REMOTE_ADDR");
            $userip = $_SERVER['REMOTE_ADDR'];
        
            if($userip == $config_server_ip) // if we get the server IP address form user
	    { 
                include('index.php');
                echo "<script type=\"text/javascript\">
    document.getElementById(\"errorMessage\").innerHTML = \"You must disable proxy for $config_server_ip to use internet.\";
</script>";
            }
	    else
	    {
                // sql to validate user
                $sql = "SELECT userid FROM user WHERE username='$username' AND password='$password' AND status='1'";
                $resultSet = $conn->query($sql);

                if($resultSet->fetchColumn() > 0)  // user has been validated get the userid
		{                
                    $row = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
                    $userid = $row['userid'];
                        
                    // TODO change logged in status to 1 database
                    //if IP or userid logged in disable further login
                    $sql = "select count(*) from loggedin where ip='$userip' OR userid='$userid'";
                    $resultSet = $conn->query($sql);

                    if($resultSet->fetchColumn() > 0)
		    {
                        $status = 1; // user/pc logged in
                    }
                
                    if($status != '1')
		    {
                        // loglogin
                        // $logintime = date("Y-m-d H:i:s");
                        $logintime = Utility::getCurrentTimeStamp();
                        $sql = "insert into loglogin values(NULL, '$userid', '$userip', '$logintime', NULL, NULL)";
                        $conn->exec($sql);
                    
                        $sql = "insert into loggedin values('$userip', '$userid', '$logintime')";
                        $conn->exec($sql);
                    }

                    // TODO set session variable for user
                    $_SESSION['user']['userid'] = $userid;
                    $_SESSION['user']['username'] = $_REQUEST['username'];
                    $_SESSION['user']['logged_in'] = true;
                    $_SESSION['user']['userip'] = $userip;
                    
		    if(!isset($_SESSION['user']['logintime']))
		    {
                        $_SESSION['user']['logintime'] = $logintime; 
                    }
                    include('userpanel.php');
                }
		else
		{
                    include('index.php');
                    if($username != "" || $password != "")
		    {
?>
			<script type="text/javascript">
		       	 document.getElementById("errorMessage").innerHTML = "Username and Password do not match, please re-insert your credentials.";
			 </script>


<?php
		    }
	        }

  	  }

       }catch(PDOException $pe){
       
		echo $pe->getMessage();
	}

    }

?>
