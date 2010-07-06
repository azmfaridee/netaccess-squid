<?php
   
    session_start();
    
    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
        require_once('../../conf/db.inc.php');
        require_once('class.userloggenerator.php');
        require_once('../common/admin_header_footer.php');
    
        $pdoConnection =  new PDO_connection();
        $conn = $pdoConnection->getConnection();
    
        $userid = $_REQUEST['userid'];
                
                
        if($_REQUEST['logintime'] == "" || $_REQUEST['logouttime'] == "" || $_REQUEST['userip'] == "")
	{
            $userLogGenerator = new UserLogGenerator($conn, $userid, 6 , "" , "", ""); // 6 is the value for Dhaka
            list($userListHTML) = $userLogGenerator->getUserLogListHTML(); 
        }                
        else 
        {
            $logintime = $_REQUEST['logintime'];
            $logouttime = $_REQUEST['logouttime'];
            $userip = $_REQUEST['userip'];
    
            $userLogGenerator = new UserLogGenerator($conn, $userid, 6, $logintime, $logouttime, $userip); // 6 is the value for Dhaka
            list($userListHTML, $view_logintime, $view_logouttime) = $userLogGenerator->getUserLogHTML();                         
        }
                
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>User Log</title>


    <style>

    table {
        table-layout: fixed;
        width: 800px;
        caption-side: bottom;
        border-collapse: collapse;
        border: 1px solid #FFFFFF;
    }

    table td, table th {
        padding: 4px; 
    }

    table th {
        background: #b9d9f3;
        color: white; 
    }

    .timestamp{
        width: 100px;
        text-align: center;
        word-break: break-all;
    }

    .url{
        width: 500px;
        text-align: left;
        word-break: break-all;
    }

    .size{
        width: 100px;
        text-align: right;
        word-break: break-all;
    }

    .mime{
        width: 100px;
        text-align: left;
        word-break: break-all;
    }

    </style>


</head>
<body>

<?php
      add_header($config_docroot);
?>

   <br/><br/><br/>

   <div align="center">User Log</div>

<?php

     if($_REQUEST['userid'] != "")
     {	
         $sql_getname = "SELECT username FROM user WHERE userid='$userid'";
         $row =  $conn->query($sql_getname)->fetch(PDO::FETCH_ASSOC);
         $username= $row['username'];
        
         echo "<div align='center'><strong>User Name:</strong>&nbsp;".$username."</div>";
     }
        
?>


<?php
        
      if($_REQUEST['logintime'] == "" || $_REQUEST['logouttime'] == "" || $_REQUEST['userip'] == "")
      {
        
        
?>

	<div align="center">
    	<table style="width:800px">
    	   <thead>
	      <th class="userip">User ip</th>
    	      <th class="logintime">logintime</th>
     	      <th class="logoutime">logoutime</th>
           </thead>
    	   <tbody>

<?php
	      echo $userListHTML;
?>

	  </tbody>
    	</table>
	</div>

<?php
        
      }
      else
      {
         
	 echo "<br /><div align='center'>In: &nbsp;".$view_logintime."&nbsp; &nbsp; Out: &nbsp;".$view_logouttime."</div>";

?>


<br />

   <div align="center">
      <table style="width:800px">
       <thead>
          <th class="timestamp">Time Stamp</th>
    	  <th class="size">Size</th>
    	  <th class="url">Request URL</th>
    	  <th class="type">File Type</th>
       </thead>
       <tbody>

<?php
        echo $userListHTML;
?>
       </tbody>
     </table>
   </div>

<?php
        
      } //else closing
?>


   <br />

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