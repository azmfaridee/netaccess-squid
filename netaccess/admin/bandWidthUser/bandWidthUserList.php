<?php
   
    session_start();
    
    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
        require_once('../../conf/db.inc.php');
        require_once('class.bandwidthListgenerator.php');
        require_once('../common/admin_header_footer.php');
    
        $pdoConnection =  new PDO_connection();
        $conn = $pdoConnection->getConnection();
        
        $userid = $_REQUEST['userid'];
        
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Bandwidth Information</title>
</head>
<body>

<?php
    add_header($config_docroot);
?>

   <br /><br />
   <div align="center" id="infoMessage"></div>
   <br />
   <div align="center">
    <legend>Bandwidth Information</legend>

    <table border="1" cellpadding="0" cellspacing="0">
       <thead>
         <tr>
   	 <th>&nbsp; User ID &nbsp;</th>
  	 <th>&nbsp; User Name &nbsp;</th>
    	 <th>&nbsp; Bandwidth &nbsp;</th>
	 <th>&nbsp; Remaining Bandwidth &nbsp;</th>
	 <th>&nbsp; Cost &nbsp;</th>
    	 </tr>
       </thead>
       <tbody>

<?php

        $bandwidtGeneratorList  = new BandwidthListGenerator($conn,$userid,$config_currency);
        $bandwidthList  = $bandwidtGeneratorList->getUserBandwidthList();
        echo $bandwidthList;
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