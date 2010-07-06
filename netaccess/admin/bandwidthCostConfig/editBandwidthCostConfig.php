<?php

    require_once('../../conf/db.inc.php');
    require_once('../../utils/class.Utility.php');
    
    $pdoConnection =  new PDO_connection();
    $conn = $pdoConnection->getConnection();
    
    $free_bandwidth = $_REQUEST['free_bandwidth'];
    $cost_per_mb = $_REQUEST['cost_per_mb'];
   
    if($free_bandwidth == "" || $cost_per_mb == "")
    {
        include('bandwidthCostConfig.php');
?>
	<script>
      	   errorMessage = document.getElementById("errorMessage");
    	   errorMessage.innerHTML = "Make sure Free bandwidth field and Cost per MB field are not blank";
    	 </script>

<?php
   
    }
			
    // check for numeric value
    else if(!(is_numeric($free_bandwidth) && is_numeric($cost_per_mb)))
    {
        include('bandwidthCostConfig.php');
?>
	<script>
           errorMessage = document.getElementById("errorMessage");
       	    errorMessage.innerHTML = "Please make sure data is valid";
	</script>
<?php
    
    }
			
    // check for negative value
    else if($free_bandwidth < 1 || $cost_per_mb < 1)
    {
        include('bandwidthCostConfig.php');
?>
	<script>
	   errorMessage = document.getElementById("errorMessage");
	   errorMessage.innerHTML = "Please make sure data is greater then Zero";
	</script>

<?php
	
     }

     else
     {
      
        $sql = "insert into config values(NULL, '$free_bandwidth', '$cost_per_mb', NULL)";
        $stmt = $conn->prepare($sql);

        if($stmt->execute())
	{
	   include('bandwidthCostConfig.php');
?>

	   <script>
              errorMessage = document.getElementById("errorMessage");
              errorMessage.innerHTML = "Data update into database successfully<br/>";
              errorMessage.setAttribute("style", "color:green");
           </script>

<?php
           // if everything fails, that means an error
        }			
        else
        {
	   include('bandwidthCostConfig.php');
?>
           <script>
              errorMessage = document.getElementById("errorMessage");
              errorMessage.innerHTML = "There was some error while update, please try again";
	   </script>
<?php  
        }

    }

?>
