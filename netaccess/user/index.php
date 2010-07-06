<?php

    session_start();
    
    require_once('../conf/db.inc.php');
    require_once('../utils/class.Utility.php');
	
    $pdoConnectionUserCheck =  new PDO_connection();
    $connUserCheck = $pdoConnectionUserCheck->getConnection();

    $userLoginStatus = 0;
	
    if(isset($_SESSION['user']['userid']))
    {
	$userid = $_SESSION['user']['userid'];
	$query = "select count(*) from loggedin where userid='$userid'";
	$userLoginStatus = $connUserCheck->query($query)->fetchColumn();
    }
	
    //close the connection
    $pdoConnectionUserCheck = null;
	
    if(isset($_SESSION['user']['userid']) && isset($_SESSION['user']['logged_in']) && ($_SESSION['user']['logged_in'] == true) && ($userLoginStatus > 0) )
    {
        include('login.php');
    }
    else
    {

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>User Login</title>
</head>
<body>
    <div align="center"><img src="../images/header.png"></img></div>
    <p>&nbsp;</p>
    <div id="errorMessage" align="center" style="color:red"></div>
    <br/>
    <div align="center">        
        <fieldset style="width:300px">
            <legend align="center" style="font-size:18">User Login</legend>
            <form id="userLoginForm" method="post" action="login.php"> 
                <table>
                   <tr>
                      <td><label for="username">User Name</label></td><td><input type="text" name="username" id="username" /></td>
                   </tr>
                   <tr>
                     <td><label for="password">Password</label></td><td><input type="password" name="password" id="password" /></td>
                   </tr>
                   <tr>
                     <td></td><td><input type="submit" value="Submit"/></td>
                   </tr>
                </table>              
            </form>
        </fieldset>
    </div>  
</body>
</html>

<?php

    }

?>
