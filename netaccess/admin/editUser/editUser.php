<?php

    session_start();
    
    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
        require_once('../../conf/db.inc.php');
        require_once('../common/admin_header_footer.php');
    
        $pdoConnection =  new PDO_connection();
        $conn = $pdoConnection->getConnection();
    
        $userid = $_REQUEST['userid'];
    
        $sql = "select * from user where userid='$userid'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bindColumn('username', $username);
        //    $stmt->bindColumn('password', $password);
        $stmt->bindColumn('roomno', $roomno);
        $stmt->fetch(PDO::FETCH_BOUND);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Edit User Infomation</title>
    <!--<script type="text/javascript">
        function checkFormValidity(){
            passoword = document.getElementById("password").getAttribute("value");
            confpassword = document.getElementById("confpassword").getAttribute("value");
            if(passoword != confpassword){
                alert("The passwords dont match, please check them once more");
            }else if(passoword == ""){
                alert("Passwors cannot be left blank, please eneter a non empty passoword");
            }
        }
    </script>-->
</head>
<body>

   <?php
       add_header($config_docroot);
   ?>

<br/><br/><br/>

   <div align="center" id="infoMessage"></div>
   <br/>
   <div align="center"><form name="userReg" action="updateUser.php" method="POST">
   <input type="hidden" name="userid" value="<?php echo($userid);?>"/>
   <fieldset style="width:400px">
      <legend>Edit User Info</legend>
      <table border="0" cellpadding="0" cellspacing="0">
         <tbody>
     	    <tr>
      	       <td width="150px">User Name</td>
      	       <td><input type="text" name="username" value="<?php echo($username);?>"/></td>
       	    </tr>
      	    <tr>
      	       <td>Room No</td>
	       <td><input type="text" name="roomno" value="<?php echo($roomno);?>"/></td>
    	    </tr>
	    <tr>
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
