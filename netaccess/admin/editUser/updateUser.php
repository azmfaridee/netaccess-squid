<?php

    require_once('../../conf/db.inc.php');
    require_once('../../utils/class.Utility.php');
    
    $pdoConnection =  new PDO_connection();
    $conn = $pdoConnection->getConnection();
    
    $userid = $_REQUEST['userid'];
    $username = $_REQUEST['username'];
    $roomno = $_REQUEST['roomno'];
    $password = $_REQUEST['password'];
    $confpassword = $_REQUEST['confpassword'];
    
    if($password != $confpassword)
    {
        include('editUser.php');
?>
	<script type="text/javascript">
           infoMessage = document.getElementById("infoMessage");
           infoMessage.innerHTML = "Passwords don't match, please re-check";
           infoMessage.setAttribute("style", "color:red;font-size:20");
	</script>

<?php
    
    }
    else if($password == "")
    {
	include('editUser.php');

?>
	<script type="text/javascript">
	   infoMessage = document.getElementById("infoMessage");
	   infoMessage.innerHTML = "Password cannot be left blank, please enter a non-empty password";
    	   infoMessage.setAttribute("style", "color:red;font-size:20");
	</script>

<?php

    }
    else
    {
	 // convert to md5 password
	 $password = md5($password);
    	 //$sql = Utility::generateSafeQuery($sql
    	 $sql = "update user set username='$username', roomno='$roomno', password='$password' where userid='$userid'";
    	 $conn->exec($sql);
    	 include('../showUser/showuser.php');
?>
	<script type="text/javascript">
    	   infoMessage = document.getElementById("infoMessage");
    	   infoMessage.innerHTML = "User information updated successfully";
      	   infoMessage.setAttribute("style", "color:green;font-size:20");
	</script>

<?php

    }
?>
