<?php
	$con = mysql_connect("localhost","root","");
	if (!$con)
	{
		die ('Could not connect: ' . mysql_error());
	}
	mysql_select_db("dbmain", $con);
	
	if(!isset($_SESSION['userName']))
	{
		// session not logged in
		$userID = 0;
		$userType ="none";
	} else
	{
		// session logged
		$userName = $_SESSION['userName'];
		
		$data = mysql_query("SELECT * FROM user WHERE (USER_USERNAME='$userName')") 
		or die(mysql_error()); 
		$info = mysql_fetch_array( $data );
		$userID = $info['USER_ID'];
		$userType = $info['USER_TYPE'];
	}
	
	if(isset($_POST['link']) && $_POST['link']=='true')
	{	
		$linkID = $_POST["linkID"];
		$sql = "DELETE FROM link WHERE LINK_ID=$linkID";
		if (!mysql_query($sql,$con))
		{
			die ('Error: ' . mysql_error());
			header("location: index.php?action=54");
		} else 
		{
			$sql = "DELETE FROM rating WHERE RATING_ID=$linkID";
			if (!mysql_query($sql,$con))
			{
				die ('Error: ' . mysql_error());
				header("location: index.php?action=54");
			} else
			{
				header("location: index.php?action=55");
			}
		}
	} else if(isset($_POST['user']) && $_POST['user']=='true')
	{	
		$uID = $_POST["userID"];
		$sql = "UPDATE link SET USER_ID=$userID WHERE USER_ID=$uID";
		if (!mysql_query($sql,$con))
		{
			die ('Error: ' . mysql_error());
			header("location: index.php?action=56");
		} else 
		{
			$sql = "DELETE FROM friend WHERE (USER_ID=$uID) OR (FRIEND_ID=$uID)";
			if (!mysql_query($sql,$con))
			{
				die ('Error: ' . mysql_error());
				header("location: index.php?action=56");
			} else
			{
				$sql = "UPDATE comment SET USER_ID=$userID WHERE USER_ID=$uID";
				if (!mysql_query($sql,$con))
				{
					die ('Error: ' . mysql_error());
					header("location: index.php?action=56");
				} else
				{
					$sql = "DELETE FROM user WHERE (USER_ID=$uID)";
					if (!mysql_query($sql,$con))
					{
						die ('Error: ' . mysql_error());
						header("location: index.php?action=56");
					} else
					{
						header("location: index.php?action=57");
					}
				}
			}
		}
	} else if(isset($_POST['comment']) && $_POST['comment']=='true')
	{	
		$comID = $_POST["commentID"];
		$sql = "DELETE FROM comment WHERE COMMENT_ID=$comID";
		if (!mysql_query($sql,$con))
		{
			die ('Error: ' . mysql_error());
			header("location: index.php?action=58");
		} else 
		{
			header("location: index.php?action=59");
		}
	} else if(isset($_POST['rating']) && $_POST['rating']=='true')
	{	
		$ratID = $_POST["ratingID"];
		$sql = "UPDATE rating SET RATING_SCORE=0.00, RATING_TOTAL=0.00 WHERE RATING_ID=".$ratID;
		if (!mysql_query($sql,$con))
		{
			die ('Error: ' . mysql_error());
			header("location: index.php?action=60");
		} else 
		{
			header("location: index.php?action=61");
		}
	} else if(isset($_POST['upgrade']) && $_POST['upgrade']=='true')
	{	
		$uID = $_POST["userID"];
		$sql = "UPDATE user SET USER_TYPE='A' WHERE USER_ID=$uID";
		if (!mysql_query($sql,$con))
		{
			die ('Error: ' . mysql_error());
			header("location: index.php?action=62");
		} else 
		{
			header("location: index.php?action=63");
		}
	} else if(isset($_POST['delete']) && $_POST['delete']=='true')
	{	
		$userName = $_POST["userName"];
		
		$data = mysql_query("SELECT * FROM user WHERE (USER_USERNAME='$userName')") 
		or die(mysql_error()); 
		$info = mysql_fetch_array( $data );
		$delID = $info['USER_ID'];
		
		
		
		$sql = "DELETE FROM comment WHERE (USER_ID=$delID)";
		if (!mysql_query($sql,$con))
		{
			die ('Error: ' . mysql_error());
			header("location: index.php?action=64");
		} else 
		{
			$sql = "DELETE FROM friend WHERE (USER_ID=$delID) OR (FRIEND_ID=$delID)";
			if (!mysql_query($sql,$con))
			{
				die ('Error: ' . mysql_error());
				header("location: index.php?action=64");
			} else
			{
				$sql = "DELETE FROM link WHERE (USER_ID=$delID)";
				if (!mysql_query($sql,$con))
				{
					die ('Error: ' . mysql_error());
					header("location: index.php?action=64");
				} else
				{
					$sql = "DELETE FROM user WHERE (USER_ID=$delID)";
					if (!mysql_query($sql,$con))
					{
						die ('Error: ' . mysql_error());
						header("location: index.php?action=64");
					} else
					{
						if (isset($_SESSION)) 
						{
							session_destroy();
						}
						//header("location: index.php");
						header("location: index.php?action=65");
					}
				}
			}
		}
	}
	
	
?>

<!DOCTYPE html>
<html>
    <head>
		<link rel="stylesheet" href="./css/reg.css" type="text/css" media="screen" charset="utf-8"/>
		<link rel="stylesheet" href="css/links.css"/>
	</head>
	<body>
		<div id="enter">
		<?php
		?>
		</div>
	</body>
</html>
		