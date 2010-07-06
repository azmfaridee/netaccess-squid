<?php
    require_once('../conf/db.inc.php');
    
    $pdoConnection =  new PDO_connection();
    $conn = $pdoConnection->getConnection();
    
    $adminid = $_SESSION['admin']['adminid'];
    $sql = "update admin set logged_in=0 where adminid='$adminid'";
    $conn->exec($sql);
    
    session_start();
    session_unset();
    session_destroy();
        
    header('location:index.php');
?>