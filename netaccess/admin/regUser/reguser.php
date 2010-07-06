<?php

    require_once('../../conf/db.inc.php');
    require_once('../../utils/class.Utility.php');
    
    $pdoConnection =  new PDO_connection();
    $conn = $pdoConnection->getConnection();
    
    $username = $_REQUEST['username'];
    $roomno = $_REQUEST['roomno'];
    $password = $_REQUEST['password'];
    $confpassword = $_REQUEST['confpassword'];
    
    if($username == "" || $password == "")
    {
       include('adduser.php');
?>

	<script>
	   errorMessage = document.getElementById("errorMessage");
    	   errorMessage.innerHTML = "Make sure user field and password field are not blank";
	</script>

<?php

    }

    // check for password mismatch
    else if($confpassword != $password)
    {
       include('adduser.php');
?>
       <script>
          errorMessage = document.getElementById("errorMessage");
          errorMessage.innerHTML = "Please make sure both the passwords match";
       </script>

<?php
  
    }
    else
    {
       // check for duplicate username
       $sql  = "select count(*) from user where username='$username'";
       // $sql = Utility::generateSafeQuery($sql);
       $resultSet  = $conn->query($sql);
    
	if($resultSet->fetchColumn() > 0)
	{
	   include('adduser.php');
?>

	   <script>
              errorMessage = document.getElementById("errorMessage");
              errorMessage.innerHTML = "Please choose another username";
    	   </script>

<?php
        }
	else
	{
            // if all clear, insert the user
            $password = md5($password); // convert to md5 hashed password
            //            $sql = Utility::generateSafeQuery($sql);
            $sql = "insert into user values(NULL, '$roomno', '$username', '$password', '1')";
            $stmt = $conn->prepare($sql);

            if($stmt->execute())
	    {
               include('adduser.php');
?>

               <script>
                  errorMessage = document.getElementById("errorMessage");
                  errorMessage.innerHTML = "Userinfo entered into database successfully<br/>Please add more users if necessary";
                  errorMessage.setAttribute("style", "color:green");
               </script>
<?php
		// if everything fails, that means an error
            }
	    else
	    {
               include('adduser.php');
?>
	       <script>
                  errorMessage = document.getElementById("errorMessage");
                  errorMessage.innerHTML = "There was some error in registering the user, please try again";
	       </script>
<?php  
	    }
        }
    }
?>
