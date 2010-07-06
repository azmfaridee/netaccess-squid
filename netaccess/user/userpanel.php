<?php
        
    require_once('../conf/db.inc.php');
    require_once('class.bandwidthgenerator.php');

    $pdoConnection =  new PDO_connection();
    $conn = $pdoConnection->getConnection();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Login Successful</title>
</head>
<body>
    <div align="center">
    <div align="center" id="header" style="position:relative;width:800px"><img src="../images/header.png"></div>
    <br />
    <div align="center" id="infoMessage" style="font-size:20;position:relative;width:800px">Please enjoy your browsing.</div>
    <div align="left" id="userInfo" style="position:relative;width:800px">

<?php
            echo "User Name: " . $_SESSION['user']['username'] . "<br />";
            echo "User IP address: " . $_SESSION['user']['userip']."<br />";
                                
            $userid = $_SESSION['user']['userid'];
                                
            $bandwidtGenerator  = new BandwidthGenerator($conn,$userid, $config_currency);
            $bandwidth  = $bandwidtGenerator->getUserBandwidth();
            echo "<br />".$bandwidth;                             
 ?>

    </div>
    <div align="right" id="logOut" style="position:relative;width:800px"><a href="logout.php">Logout</a></div>
    <p><div id="redirectMessage"></div></p>
  
    <script type="text/javascript">
        //redirectTime = 5000;
        //redirectUrl = "http://www.google.com.bd/";
        //  setTimeout("location.href = redirectUrl", redirectTime);
    </script>
   
    </div>
</body>
</html>