<html>
	<head>
	<?php
		session_start();
		if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 200000))
		{
			if ($_FILES["file"]["error"] > 0)
			{
				header("location: ../index.php?action=68");
			}
			else
			{
				if(!isset($_SESSION['userName']))
				{
					// session not logged in
					$userID = 0;
					header("location: ../index.php?action=66");
				} else
				{
					// session logged
					$con = mysql_connect("localhost","root","");
					if (!$con)
					{
						die ('Could not connect: ' . mysql_error());
					}
					mysql_select_db("dbmain", $con);	  
					$userName = $_SESSION['userName'];
					
					if (file_exists("upload/users/$userName.jpg"))
					{
						//The file exists so it should be removed
						unlink("upload/users/$userName.jpg");
					}
					if (file_exists("upload/users/$userName.gif"))
					{
						//The file exists so it should be removed
						unlink("upload/users/$userName.gif");
					}
					if ($_FILES["file"]["type"] == "image/gif")
						$pic = $userName.".gif";
					else if (($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg"))
						$pic = $userName.".jpg";
					
					move_uploaded_file($_FILES["file"]["tmp_name"],"upload/users/" . $pic);
					$con = mysql_connect("localhost","root","");
					if (!$con)
					{
						die ('Could not connect: ' . mysql_error());
					}
					mysql_select_db("dbmain", $con);	  
					$sql = "UPDATE user SET user.USER_PIC_LOCATION='$pic' WHERE (user.USER_USERNAME='$userName')";
					if (!mysql_query($sql,$con))
					{
						header("location: ../index.php?action=66");
						die;
					}
					header("location: ../index.php?action=67");
				}
			}
		}
		else
		{
			header("location: ../index.php?action=68");
		}
		session_end();
	?>
	</head>
	<body>
	</body>
</html>