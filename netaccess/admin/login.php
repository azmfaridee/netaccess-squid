<?php

   session_start();
   require_once('../conf/db.inc.php');
    
   $pdoConnection =  new PDO_connection();
   $conn = $pdoConnection->getConnection();
    
   if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
   {
      include('adminpanel.php');
   }
   else
   {
      $adminname = $_REQUEST['adminname'];
      $password = $_REQUEST['password'];
      $password = md5($password);
      $statusMessage = $_REQUEST['q'];

      $sql = "select count(*) from admin where adminname='$adminname' and password='$password'";
      $resultSet = $conn->query($sql);

      // if admin has beeb validated
      if($resultSet->fetchColumn() > 0)
      {
          $sql = "select * from admin where adminname='$adminname' and password='$password'";
          $row = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
          $status = $row['logged_in'];
          $adminid = $row['adminid'];

          $sql = "update admin set logged_in=1 where adminid='$adminid'";
          $conn->exec($sql);
          // TODO set session variable for admin
          $_SESSION['admin']['adminid'] = $adminid;
          $_SESSION['admin']['adminname'] = $_REQUEST['adminname'];
          $_SESSION['admin']['logged_in'] = true;

          include('adminpanel.php');
          if(isset($statusMessage) && $statusMessage == 20)
	  {

?>

<script type="text/javascript">
    infoMessage = document.getElementById("statusMessage");
    infoMessage.innerHTML = "Admin Info updated successfully";
    infoMessage.setAttribute("style", "color:green;font-size:20");
</script>

<?php                
	 }
     }
     else
     {
	include('index.php');
?>

<script type="text/javascript">
    document.getElementById("errorMessage").innerHTML = "Admin name and Password do not match, please re-insert your credentials."
</script>

<?php
     }
   }
?>
