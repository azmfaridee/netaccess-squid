<?php

    session_start();    
    
    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
        require_once('../common/admin_header_footer.php');
	require_once('../../conf/db.inc.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>User Registration</title>
</head>
<body>

   <?php
      add_header($config_docroot);
   ?>

   <p>&nbsp;</p>
   <div align="center" style="font-size:20">Register User</div>
   <div id="errorMessage" style="color:red" align="center"></div>
   <div align="center"><form name="userReg" action="reguser.php" method="POST">
   <fieldset style="width:400px">
       <legend>Enter User Info</legend>
   	  <table border="0" cellpadding="0" cellspacing="0">
    	     <tbody>
		<tr>
		   <td width="150px">User Name</td>
    		   <td><input type="text" name="username" /></td>
    		</tr>
    		
		<tr>
		   <td>Room No</td>
    		   <td><input type="text" name="roomno" /></td>
    		</tr>
    		
		<tr>
    		   <td>Password</td>
    		   <td><input type="password" name="password" /></td>
    		</tr>
    		
		<tr>
    		   <td>Confirm Pass</td>
    		   <td><input type="password" name="confpassword" /></td>
    		</tr>
		
		<tr>
		   <td>&nbsp;</td>
		   <td>&nbsp;</td>
		</tr>
		
		<tr>
		   <td>&nbsp;</td>
    		   <td><input type="submit" value="Register" /></td>
    		</tr>
    	   </tbody>
    	</table> 
   </fieldset>
  </form>
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