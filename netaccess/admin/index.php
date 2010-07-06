<?php

    session_start();
    
    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
        include('adminpanel.php');
    } 
    else 
    {
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <div align="center"><img src="../images/header_admin.png"></div>
    <p>&nbsp;</p>
    <div id="errorMessage" align="center" style="color:red"></div>
    <br/>
    <div align="center">        
    	 <fieldset style="width:300px">
           <legend align="center" style="font-size:18">Admin Login</legend>
	      <form id="userLoginForm" method="post" action="login.php">  
                <table>
		 <tr><td><label for="adminname">Admin Name</label></td><td><input type="text" name="adminname" id="adminname" /></td></tr>
		 <tr><td><label for="password">Password</label></td><td><input type="password" name="password" id="password" /></td></tr>
                 <tr><td></td><td><input type="submit" value="Submit"/></td></tr>
                </table>              
              </form>
        </fieldset>
    </div>  
</body>
</html>

<?php

    } //close else
?>