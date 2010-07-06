<?php

    session_start();
    
    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
        require_once('../../conf/db.inc.php');
        require_once('../common/admin_header_footer.php');
    
        $pdoConnection =  new PDO_connection();
        $conn = $pdoConnection->getConnection();
    
        $adminid = $_SESSION['admin']['adminid'];
        $adminname = $_SESSION['admin']['adminname'];
    
        $sql = "select * from admin where adminid='$adminid'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bindColumn('adminname', $adminname);
        $stmt->bindColumn('password', $password);
        $stmt->fetch(PDO::FETCH_BOUND);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Edit Admin</title>
</head>
<body>
   
<?php 
        add_header($config_docroot);
?>
    <br/><br/><br/>

    <div align="center" id="infoMessage"></div>
    <br/>
    <div align="center">
       <form name="editAdmin" action="updateAdmin.php" method="POST">
          <input type="hidden" name="adminid" value="<?php echo($adminid);?>"/>
	  <fieldset style="width:400px">
             <legend>Edit Admin Details</legend>
                <table border="0" cellpadding="0" cellspacing="0">
            	    <tbody>
                       <tr>
                          <td width="150px">Admin Name</td>
                       	  <td><input type="text" name="adminname" value="<?php echo($adminname);?>"/></td>
                       </tr>
			  <td>Password</td>
                       	  <!--<td><input type="password" name="password" value="<?php //echo($password);?>"/></td>-->
                       	  <td><input type="password" name="password" id="password" value=""/></td>
                       </tr>
                       <tr>
                          <td>Confirm Pass</td>
                       	  <!--<td><input type="password" name="confpassword" value="<?php //echo($password);?>"/></td>-->
                       	  <td><input type="password" name="confpassword" id="confpassword" value=""/></td>
                       </tr>
                       <tr>
                          <td></td>
                       	  <td><input type="submit" value="Update" /></td>
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