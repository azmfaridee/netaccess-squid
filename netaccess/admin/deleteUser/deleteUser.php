<?php

    session_start();
    
    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
        require_once('../../conf/db.inc.php');
    
        $pdoConnection =  new PDO_connection();
        $conn = $pdoConnection->getConnection();
    
        $userid = $_REQUEST['userid'];
    
        $sql = "update user set status='0' where userid='$userid'";
        $count = $conn->exec($sql);
        if($count > 0)
	{
            // success
            include('../showUser/showuser.php');
?>

	    <script type="text/javascript">
	       infoMessage = document.getElementById("infoMessage");
    	       infoMessage.innerHTML = "User Successfully Deleted";
    	       infoMessage.setAttribute("style", "color:green;font-size:20");
	    </script>
<?php

	}
    	else
    	{
?>
	    <script type="text/javascript">
    	       infoMessage = document.getElementById("infoMessage");
    	       infoMessage.innerHTML = "There was some error in deleting the user, please try again";
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