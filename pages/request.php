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
	
	if(isset($_POST['formA']) && $_POST['formA']=='true')
	{	
		$U_ID = $_REQUEST["userID"];
		$F_ID = $_REQUEST["friendID"];
		$sql = "UPDATE friend SET friend.FRIEND_STATUS='A' WHERE ((friend.USER_ID=$F_ID) AND (friend.FRIEND_ID=$U_ID))";
		if (!mysql_query($sql,$con))
		{
			die ('Error: ' . mysql_error());
		}
		Print "Accepted";
		
		
	} else if(isset($_POST['formD']) && $_POST['formD']=='true')
	{	
		//$userName = $_REQUEST["username"];
		$U_ID = $_REQUEST["userID"];
		$F_ID = $_REQUEST["friendID"];
		$sql = "UPDATE friend SET friend.FRIEND_STATUS='D' WHERE ((friend.USER_ID=$F_ID) AND (friend.FRIEND_ID=$U_ID))";
		if (!mysql_query($sql,$con))
		{
			die ('Error: ' . mysql_error());
		}
		Print "Accepted";
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
			$var1 = mysql_query("SELECT * FROM user WHERE user.USER_ID IN(SELECT USER_ID FROM friend WHERE ((friend.FRIEND_ID=$userID) AND (friend.FRIEND_STATUS='P')))") 
			or die(mysql_error()); 
			
			$num_rows = mysql_num_rows($var1);
			if ($num_rows<1)
			{
				echo "<br/><br/><br/><br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
			} else echo "<br/><br/><br/><h1> Pending invites (".$num_rows.")</h2>";
			
			$counter = 0;
			while($info = mysql_fetch_array( $var1 )) 
			{ 
				$counter++;
				if ($counter ==2)
				{
					Print "<tr width='100%'>";
				}
				if ($counter % 2!=0)
				{
					Print "<tr width='100%'>";
				}
				echo "<td>
					<hr/>
					<h1> <a>From ".$info['USER_USERNAME']." </a></h1>
					<h3> Name:       ".$info['USER_FN']."</h3>
					<h3> Surname:    ".$info['USER_LN']."</h3>
					<h3> Email:      ".$info['USER_EMAIL']."</h3>
					<h3> Birth Date: ".$info['USER_BIRTH']."</h3><br/>
					
					
					<form id='theForm' name='theForm' method='post' action='index.php?action=7'>
						<input name='userID' type='hidden' id='userID' value='".$userID."'/>
						<input name='friendID' type='hidden' id='friendID' value='".$info['USER_ID']."'/>
						
						<input name='formA' type='hidden' id='formA' value='true'>
						<input type='submit' value='Accept' id='submitButton' name='submitButton'/>
					</form>
					
					<form id='theForm2' name='theForm2' method='post' action='index.php?action=7'>
						<input name='userID' type='hidden' id='userID' value='".$userID."'/>
						<input name='friendID' type='hidden' id='friendID' value='".$info['USER_ID']."'/>
						<input name='formD' type='hidden' id='formD' value='true'>
						<input type='submit' value='Decline' id='submitButton' name='submitButton'/>
					</form>
				</td>";
				if ($counter % 2==0)
				{
					Print "</tr>";
				}
				if ($counter ==2)
				{
					Print "</tr>";
				}
			} 
		?>
		</div>
	</body>
</html>
		