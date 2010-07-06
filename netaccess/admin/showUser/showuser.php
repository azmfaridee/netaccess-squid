<?php

    session_start();
    
    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
       require_once('../../conf/db.inc.php');
       require_once('class.userlistgenerator.php');
       require_once('../common/admin_header_footer.php');
    
       $pdoConnection =  new PDO_connection();
       $conn = $pdoConnection->getConnection();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>User Information</title>
</head>
<body>

   <?php
      add_header($config_docroot);
   ?>

<br /><br />

    <div align="center" id="infoMessage"></div>
    <br />
    <div align="center">
       <legend>User Information</legend>
          <table border="1" cellpadding="0" cellspacing="0">
	     <thead>
	        <tr>
		    <th>&nbsp; User ID &nbsp;</th>
		    <th>&nbsp; User Name &nbsp;</th>
		    <th>&nbsp; Room No &nbsp;</th>
    		    <th>&nbsp; Currently Logged-in &nbsp;</th>
    		    <th>&nbsp; Actions &nbsp;</th>
		</tr>
    	     </thead>
    	    
	     <tbody>

<?php
	        $userListGenerator  = new UserListGenerator($conn);
	        $userList  = $userListGenerator->getUserList();
	        echo $userList;
?>

	     </tbody>
         </table>        
    </div>

<?php
    add_footer();
?>

</body>
</html>

<?php    

   }
   else
   {
      header('Location:../index.php');
   }
?>