<?php

    session_start();    
    
    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
	require_once('../../conf/db.inc.php');
        require_once('../common/admin_header_footer.php');
		
	$pdoConnection =  new PDO_connection();
        $conn = $pdoConnection->getConnection();	
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

<br />

<?php
	
	//get maxtime
	$sql_max_timestamp = "SELECT MAX(timestamp) AS timestamp FROM config";
	$row =  $conn->query($sql_max_timestamp)->fetch(PDO::FETCH_ASSOC);
	$max_timestamp = $row['timestamp'];
	
	//get data from the last timestamp
	$sql_free_bandwidth_with_price = "SELECT * FROM config where timestamp='$max_timestamp'";
	$row =  $conn->query($sql_free_bandwidth_with_price)->fetch(PDO::FETCH_ASSOC);
	$free_bandwidth = $row['free_bandwidth'];
	$price_per_mb = $row['price_per_mb'];
	$lastupdate = $row['timestamp'];
	
		
	echo "<div align='center'>";
	
	echo "<table>";
	echo "<tr>";
	echo "<td>Free bandwidth for all users: &nbsp;</td><td>".$free_bandwidth." MB</td>";
	echo "</tr><tr>";
	echo "<td>Cost per mega byte: </td><td>".$price_per_mb.$config_currency."</td>";
	echo "</tr>";
	echo "</table>";

	
	echo "<br /><br /> <code> Last update on: ".$lastupdate."</code>";
	echo "</div>";
	
?>

<br /><br />

    <div align="center" style="font-size:20">Change bandwidth cost config</div>
    <div id="errorMessage" style="color:red" align="center"></div>
    <div align="center"><form name="userReg" action="editBandwidthCostConfig.php" method="POST">
    <fieldset style="width:400px">
       <legend>Enter Info</legend>
          <table border="0" cellpadding="0" cellspacing="0">
       	     <tbody>
	       <tr>
	          <td width="150px">Free bandwidth</td>
	       	  <td><input type="text" name="free_bandwidth" /> &nbsp; MB</td>
    	       </tr>
    	       <tr>
    	          <td>Cost per MB</td>
    	       	  <td><input type="text" name="cost_per_mb" /> &nbsp;<?php echo $config_currency;?></td>
    	       </tr>
   	       <tr>
	          <td>&nbsp;</td>
	       	  <td>&nbsp;</td>
	       </tr>
    	       <tr>
	          <td>&nbsp;</td>
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