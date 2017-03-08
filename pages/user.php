<!DOCTYPE html>
<head>
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
		$data = mysql_query("SELECT USER_PIC_LOCATION FROM user WHERE (USER_USERNAME='$userName')") 
		or die(mysql_error()); 
		$info = mysql_fetch_array( $data );
		$picLocation = $info['USER_PIC_LOCATION'];
		$picLocation = 'pages/upload/users/'.$picLocation;
	}
?>


</head>
<body>
	<div>
		<div> <img src='<?php Print $picLocation ?>' alt='Logo here' width='180' height='178'/></div>
		<table width="100%">
			<tr>
				<td><a id='user_friends' name='user_friends' class='btn' href='index.php?action=1'>Friends</a></td>
			</tr>
			<tr>
				<td><a id='user_links' name='user_links' class='btn' href='index.php?action=2'>Links</a></td>
			</tr>
			<tr>
				<td><a id='user_alerts' name='user_alerts' class='btn' href='index.php?action=7'>Alerts</a></td>
			</tr>
			<tr>
				<td><a id='user_alerts' name='user_alerts' class='btn' href='index.php?action=5'>Search</a></td>
			</tr>
		</table>
		<hr/>
	</div>
<body>