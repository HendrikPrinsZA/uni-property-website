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
	} else
	{
		// session logged
		$userName = $_SESSION['userName'];
		
		$data = mysql_query("SELECT USER_ID FROM user WHERE (USER_USERNAME='$userName')") 
		or die(mysql_error()); 
		$info = mysql_fetch_array( $data );
		$userID = $info['USER_ID'];
	}
	
	if(!isset($_SESSION['linkOption']))
	{
		// session not logged in
		$option = 0;
	} else
	{
		// session logged 
		$option = $_SESSION['linkOption'];
	}
	
	$sql = "SELECT * FROM friend WHERE ($userID=friend_ID AND $option=user_ID) OR ($option=friend_ID AND $userID=user_ID)";	
	$result = mysql_query($sql);
	if (mysql_num_rows($result)<1)
	{
		$sql = "INSERT INTO friend(USER_ID,FRIEND_ID,FRIEND_STATUS) VALUES ($userID,$option,'P')";
		if (!mysql_query($sql,$con))
		{
			die;
			header("location: index.php?action=53");
		}
		header("location: index.php?action=52");
	} else
			header("location: index.php?action=53");
?>
<!DOCTYPE html>
<html>
    <head>
		<link rel="stylesheet" href="./css/reg.css" type="text/css" media="screen" charset="utf-8"/>
		<link rel="stylesheet" href="css/links.css"/>
	</head>
	<body>
		<?php
		 echo $userID."<br/>".$option;
		?>
	
	</body>
</html>
		