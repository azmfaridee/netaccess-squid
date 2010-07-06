<?php

    session_start();
    
    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
        require_once('../../conf/db.inc.php');
        require_once('../../utils/class.Utility.php');
    
        $pdoConnection =  new PDO_connection();
        $conn = $pdoConnection->getConnection();
    
        $userid = $_REQUEST['userid'];
        
        //get the login time from user
        $sql = "select time from loggedin where userid='$userid'";
        $resultSet = $conn->query($sql);
        if($resultSet->fetchColumn() > 0)
	{  			
	    // user has been validated get the userid
            $row = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
            $logintime = $row['time'];

            // update loglogin
            $logouttime = Utility::getCurrentTimeStamp();		
            $logouttype = "kickout";
            $sql =  "update loglogin set logouttime='$logouttime', logouttype='$logouttype' where userid='$userid' and logintime='$logintime'";
            $conn->exec($sql);

            $sql = "delete from loggedin where userid='$userid'";
            $count = $conn->exec($sql);
            
	    if($count > 0)
	    {
                // success
                include('../showUser/showuser.php');
?>

		<script type="text/javascript">
	          infoMessage = document.getElementById("infoMessage");
	       	  infoMessage.innerHTML = "User Successfully kicked Out";
	       	  infoMessage.setAttribute("style", "color:green;font-size:20");
	        </script>

<?php
    // update session data by removing session data about the user
    //unset($_SESSION['user']);

	   }
    	   else
     	   {
		include('../showUser/showuser.php');
?>

		<script type="text/javascript">
    		   infoMessage = document.getElementById("infoMessage");
		   infoMessage.innerHTML = "There was some error in kicking the user, please try again";
	  	   infoMessage.setAttribute("style", "color:green;font-size:20");
		</script>

<?php
	   }

 	}

	else 
	{

	   include('../showUser/showuser.php');
?>


	   <script type="text/javascript">
	      infoMessage = document.getElementById("infoMessage");
	      infoMessage.innerHTML = "User is not Logged In";
    	      infoMessage.setAttribute("style", "color:green;font-size:20");
	   </script>
<?php

	}

   }
   else
   {
      header('Location:../index.php');
   }

?>