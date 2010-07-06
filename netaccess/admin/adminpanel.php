<?php

    require_once('common/admin_header_footer.php');
    require_once('../conf/db.inc.php');

    if(isset($_SESSION['admin']['adminid']) && isset($_SESSION['admin']['logged_in']) && $_SESSION['admin']['logged_in'] == true)
    {
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>Login Successful</title>
</head>
<body>

    <?php
        add_header($config_docroot);
    ?>

    <p>&nbsp;</p>
    <div align="left" id="adminInfo"><?php echo "Admin Name: " . $_SESSION['admin']['adminname'];?></div>
    <div align="right" id="logOut"><a href="logout.php">Logout</a></div>
    <div align="center" id="statusMessage" style="color:blue"></div>
    <div align="center">
        <fieldset style="width:400px" align="center">
            <legend id="adminPanel" style="font-size:20"> Admin Panel</legend>
            <div align="left" id="adminPanelItems">
                <a href="regUser/adduser.php">Add Users</a><br/>
                <a href="showUser/showuser.php">Edit/Remove Users</a><br/>
                <a href="bandWidthUser/bandWidthUserList.php">BandWidth User</a><br/>
                <a href="bandwidthCostConfig/bandwidthCostConfig.php">Bandwidth & Cost Config</a><br/>
                <a href="viewlog.php?page_no=1">View Complete Log</a><br/>
                <a href="editAdmin/editAdmin.php">Edit Admin</a>
            </div>
        </fieldset>
    </div>

    <?php
        add_footer();
    ?>

</body>
</html>

<?php
    }
?>