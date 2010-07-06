<?php
  
    require_once('../../conf/db.inc.php');
    require_once('../../utils/class.Utility.php');
    
    $pdoConnection =  new PDO_connection();
    $conn = $pdoConnection->getConnection();
    
    $adminid = $_REQUEST['adminid'];
    $adminname = $_REQUEST['adminname'];
    $password = $_REQUEST['password'];
    $confpassword = $_REQUEST['confpassword'];
    
    if($password != $confpassword)
    {
        include('editAdmin.php');
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
	include('editAdmin.php');
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
    	$sql = "update admin set adminname='$adminname', password='$password' where adminid='$adminid'";
    	$conn->exec($sql);
    	//include('../showUser/showadmin.php');
    	//include('../adminpanel.php');
?>
	<script type="text/javascript">
    	   document.location = "../login.php";
	</script>
<?php

    }
?>