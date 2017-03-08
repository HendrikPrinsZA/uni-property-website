<!DOCTYPE html>
<html>
    <head>
        <title> As 2 </title>
		<?php
            $userName = $_REQUEST["username"];
            $pass = $_REQUEST["passW"];
        ?>
        <?php
            $con = mysql_connect("localhost","root","");
            if (!$con)
            {
                die ('Could not connect: ' . mysql_error());
            }
            mysql_select_db("dbmain", $con);
			
			$qry = "SELECT USER_ID FROM USER WHERE (USER_USERNAME='$userName') AND (USER_PASSWORD='$pass')";
			$result = mysql_query($qry);
			
			
			if(mysql_num_rows($result) > 0) {
				session_start();
				$_SESSION['userName']=$userName;
				header("location: ../index.php");
				exit();
			}
			else
			{
				header("location: ../index.php?action=98");
				exit();
			}
            mysql_close($con);
        ?>
    </head>
    <body>
    </body>
</html>