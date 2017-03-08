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
			$var1 = mysql_query("CALL sp_GetUserFriends($userID)") 
			or die(mysql_error()); 
			
			$num_rows = mysql_num_rows($var1);
			if ($num_rows<1)
			{
				echo "<br/><br/><br/><br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
			} else echo "<br/><br/><br/><h1> Total friends: ".$num_rows."</h2>";
			
			
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
						<h3> Username:   ".$info['USER_USERNAME']."</h3>
						<p>".$info['USER_FN']." ".$info['USER_LN']."</p>";
					echo "</td>";
				if ($counter % 2==0)
				{
					Print "</tr>";
				}
				if ($counter ==2)
				{
					Print "</tr>";
				}
			} 
			if ($num_rows<3)
			{
				echo "<br/><br/><br/><br/><br/>";
			}
		?>
		</div>
	</body>
</html>
		