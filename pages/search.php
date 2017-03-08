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
	
	if(!isset($_SESSION['linkOption']))
	{
		// session not logged in
		$option = 0;
	} else
	{
		// session logged 
		$option = $_SESSION['linkOption'];
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Account </title>
		<?php
			$search = false;
		?>
		
		<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
		<script type="text/javascript" src="js/registration.js"></script>
		<link rel="stylesheet" href="./css/reg.css" type="text/css" media="screen" charset="utf-8"/>
		<link rel="stylesheet" href="css/links.css"/>		
    </head>
    <body>
	<?PHP
if(isset($_POST['form']) && $_POST['form']=='true')
{	
	$string = $_REQUEST["string"];
	$criteria = $_REQUEST["criteria"];	
	$search = true;
}
?>	
		<div id="enter">
			<div id="main_menu">
				<ul id="menu">
					<li><a href="index.php?action=5&linkOption=1" name="users" id="users">Search users</a></li>
					<li><a href="index.php?action=5&linkOption=2" name="links" id="links">Search properties</a></li>
				</ul>
			</div>
		
				<?php
					if ($option==2)
					{
						$searchOption = "properties";
					} else 
					{
						$searchOption = "users";
					}
				
				
					if ($search==false)
					{
					echo
					"	<div id='enter'>
						<h1> Searching for $searchOption! </h1>
						<form id='theForm' name='theForm' method='post' action='index.php?action=5'>
						<table>
							<tr>
								<td width=100%>
									<p>Search string:  <input type='text' name='string' id='string' autofocus='autofocus' placeholder='String to search' value='a' required/></p>
									<a id='inval_user'><span class='error'>Username already used</span></a>
									</td>
								<td>
							</tr>
							<tr>
								<td>
									<p> By criteria: 
									<select name='criteria'>";
										if ($option==2)
										{
											Print "<option value='1'>Description</option>";
											Print "<option value='2'>Category</option>";
											Print "<option value='3'>User who commented</option>";
											Print "<option value='4'>User who created</option>";
										} else 
										{
											Print "<option value='5'>Friends</option>";
											Print "<option value='6'>First name</option>";
											Print "<option value='7'>Last name</option>";
											Print "<option value='8'>Username</option>";
											Print "<option value='9'>Email address</option>";
										}
			echo				"</select></p><br/></br>
								<td>
							</tr>
						</table>
						<input name='form' type='hidden' id='form' value='true'/>
						<input type='submit' value='Search' id='submitButton' name='submitButton'/>
						</form>
						</div>";
					} else
					{
						echo "<br/><br/><br/><h1> Search results </h1>";
						if ($criteria==1)
						{
							$var1 = mysql_query("SELECT * FROM link,user WHERE (LINK_DESC like '% $string %') AND (link.USER_ID=user.USER_ID)") 
							or die(mysql_error());
							
							$num_rows = mysql_num_rows($var1);
							if ($num_rows<1)
							{
								echo "<br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
							} else echo "<br/><br/><h2>Resluts found: ".$num_rows."</h2>";
							
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
								Print "<td width='50%'><h3><a href='index.php?action=25&linkOption=".$info['LINK_ID']."'>".$info['LINK_NAME']."</a></h3>";
								Print "<p>".$info['LINK_DESC']."</p>";
								Print "<p> By user:".$info['USER_USERNAME']."</p></td>";
								if ($userType=="A")
								{
									echo
									"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='linkID' type='hidden' id='linkID' value='".$info['LINK_ID']."'/>
										<input name='link' type='hidden' id='link' value='true'>
										<input type='submit' value='Delete' id='submitButton' name='submitButton'/>
									</form>";
								}
								Print "<hr/>";
								if ($counter % 2==0)
								{
									Print "</tr>";
								}
								if ($counter ==2)
								{
									Print "</tr>";
								}
							} 
						} else if ($criteria==2)
						{
							$var1 = mysql_query("SELECT * FROM link,user,category WHERE (category.CAT_NAME like '%$string%') AND (link.USER_ID=user.USER_ID) AND (link.LINK_CAT_ID=category.CAT_ID)") 
							or die(mysql_error());
							
							$num_rows = mysql_num_rows($var1);
							if ($num_rows<1)
							{
								echo "<br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
							} else echo "<br/><br/><h2>Resluts found: ".$num_rows."</h2>";
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
								Print "<td width='50%'><h3><a href='index.php?action=25&linkOption=".$info['LINK_ID']."'>".$info['LINK_NAME']."</a></h3>";
								Print "<p>".$info['LINK_DESC']."</p>";
								Print "<p> By user:".$info['USER_USERNAME']."</p></td>";
								
								if ($userType=="A")
								{
									echo
									"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='linkID' type='hidden' id='linkID' value='".$info['LINK_ID']."'/>
										<input name='link' type='hidden' id='link' value='true'>
										<input type='submit' value='Delete' id='submitButton' name='submitButton'/>
									</form>";
								}
								
								if ($counter % 2==0)
								{
									Print "</tr>";
								}
								if ($counter ==2)
								{
									Print "</tr>";
								}
							} 
						} else if ($criteria==3)
						{
							$var1 = mysql_query("SELECT * FROM link,user WHERE (link.LINK_ID IN(SELECT LINK_ID FROM comment WHERE USER_ID IN(SELECT USER_ID FROM user WHERE USER_USERNAME like '%$string%'))) AND (link.USER_ID=user.USER_ID)") 
							or die(mysql_error());
							
							$num_rows = mysql_num_rows($var1);
							if ($num_rows<1)
							{
								echo "<br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
							} else echo "<br/><br/><h2>Resluts found: ".$num_rows."</h2>";
							
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
								Print "<td width='50%'><h3><a href='index.php?action=25&linkOption=".$info['LINK_ID']."'>".$info['LINK_NAME']."</a></h3>";
								Print "<p>".$info['LINK_DESC']."</p>";
								Print "<p> By user:".$info['USER_USERNAME']."</p></td>";
								
								if ($userType=="A")
								{
									echo
									"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='linkID' type='hidden' id='linkID' value='".$info['LINK_ID']."'/>
										<input name='link' type='hidden' id='link' value='true'>
										<input type='submit' value='Delete' id='submitButton' name='submitButton'/>
									</form>";
								}
								
								if ($counter % 2==0)
								{
									Print "</tr>";
								}
								if ($counter ==2)
								{
									Print "</tr>";
								}
							} 
						} else if ($criteria==4)
						{
							$var1 = mysql_query("SELECT * FROM link,user WHERE link.USER_ID IN(SELECT USER_ID FROM user WHERE USER_USERNAME like '%$string%') AND (link.USER_ID=user.USER_ID)") 
							or die(mysql_error());
							$counter = 0;
							
							$num_rows = mysql_num_rows($var1);
							if ($num_rows<1)
							{
								echo "<br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
							} else echo "<br/><br/><h2>Resluts found: ".$num_rows."</h2>";
							
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
								Print "<td width='50%'><h3><a href='index.php?action=25&linkOption=".$info['LINK_ID']."'>".$info['LINK_NAME']."</a></h3>";
								Print "<p>".$info['LINK_DESC']."</p>";
								Print "<p> By user:".$info['USER_USERNAME']."</p></td>";
								
								if ($userType=="A")
								{
									echo
									"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='linkID' type='hidden' id='linkID' value='".$info['LINK_ID']."'/>
										<input name='link' type='hidden' id='link' value='true'>
										<input type='submit' value='Delete' id='submitButton' name='submitButton'/>
									</form>";
								}
								
								
								if ($counter % 2==0)
								{
									Print "</tr>";
								}
								if ($counter ==2)
								{
									Print "</tr>";
								}
							} 
						} else if ($criteria==5)
						{
							$var1 = mysql_query("	SELECT * FROM user where (user_id IN(SELECT friend_ID AS one FROM friend WHERE (user_ID=$userID) AND (friend_status='A')
													UNION
													SELECT user_ID AS one FROM friend WHERE friend_ID=$userID AND (friend_status='A'))) AND (user_username LIKE '%$string%')
													ORDER BY user_username;") 
							or die(mysql_error());
							
							$num_rows = mysql_num_rows($var1);
							if ($num_rows<1)
							{
								echo "<br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
							} else echo "<br/><br/><h2>Resluts found: ".$num_rows."</h2>";
							
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
									<h1> <a href='index.php?action=6&linkOption=".$info['USER_ID']."'>".$info['USER_USERNAME']." </a></h1>
									<p><h3>User details:</h3></p><br/>
									<h3> Name:       ".$info['USER_FN']."</h3>
									<h3> Surname:    ".$info['USER_LN']."</h3>
									<h3> Email:      ".$info['USER_EMAIL']."</h3>
									<h3> Birth Date: ".$info['USER_BIRTH']."</h3><br/>
									";
								if ($userType=="A")
								{
									echo
									"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='userID' type='hidden' id='userID' value='".$info['USER_ID']."'/>
										<input name='user' type='hidden' id='user' value='true'>
										<input type='submit' value='Delete' id='submitButton' name='submitButton'/>
									</form><hr/>
									<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='userID' type='hidden' id='userID' value='".$info['USER_ID']."'/>
										<input name='upgrade' type='hidden' id='upgrade' value='true'>
										<input type='submit' value='Upgrade user' id='submitButton' name='submitButton'/>
									</form><hr/>";
								}
									
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
						} else if ($criteria==6)
						{
							$var1 = mysql_query("SELECT * FROM user WHERE (USER_FN LIKE '%$string%')") 
							or die(mysql_error());
							
							$num_rows = mysql_num_rows($var1);
							if ($num_rows<1)
							{
								echo "<br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
							} else echo "<br/><br/><h2>Resluts found: ".$num_rows."</h2>";
							
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
									<h1> <a href='index.php?action=6&linkOption=".$info['USER_ID']."'>".$info['USER_USERNAME']." </a></h1>
									<p><h3>User details:</h3></p><br/>
									<h3> Name:       ".$info['USER_FN']."</h3>
									<h3> Surname:    ".$info['USER_LN']."</h3>
									<h3> Email:      ".$info['USER_EMAIL']."</h3>
									<h3> Birth Date: ".$info['USER_BIRTH']."</h3><br/>
									";
								if ($userType=="A")
								{
									echo
									"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='userID' type='hidden' id='userID' value='".$info['USER_ID']."'/>
										<input name='user' type='hidden' id='user' value='true'>
										<input type='submit' value='Delete' id='submitButton' name='submitButton'/>
									</form><hr/>
									<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='userID' type='hidden' id='userID' value='".$info['USER_ID']."'/>
										<input name='upgrade' type='hidden' id='upgrade' value='true'>
										<input type='submit' value='Upgrade user' id='submitButton' name='submitButton'/>
									</form><hr/>";
								}
									
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
						
						} else if ($criteria==7)
						{
							$var1 = mysql_query("SELECT * FROM user WHERE (USER_LN LIKE '%$string%')") 
							or die(mysql_error());
							
							$num_rows = mysql_num_rows($var1);
							if ($num_rows<1)
							{
								echo "<br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
							} else echo "<br/><br/><h2>Resluts found: ".$num_rows."</h2>";
							
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
									<h1> <a href='index.php?action=6&linkOption=".$info['USER_ID']."'>".$info['USER_USERNAME']." </a></h1>
									<p><h3>User details:</h3></p><br/>
									<h3> Name:       ".$info['USER_FN']."</h3>
									<h3> Surname:    ".$info['USER_LN']."</h3>
									<h3> Email:      ".$info['USER_EMAIL']."</h3>
									<h3> Birth Date: ".$info['USER_BIRTH']."</h3><br/>
									";
								if ($userType=="A")
								{
									echo
									"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='userID' type='hidden' id='userID' value='".$info['USER_ID']."'/>
										<input name='user' type='hidden' id='user' value='true'>
										<input type='submit' value='Delete' id='submitButton' name='submitButton'/>
									</form><hr/>
									<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='userID' type='hidden' id='userID' value='".$info['USER_ID']."'/>
										<input name='upgrade' type='hidden' id='upgrade' value='true'>
										<input type='submit' value='Upgrade user' id='submitButton' name='submitButton'/>
									</form><hr/>";
								}
									
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
						} else if ($criteria==8)
						{
							$var1 = mysql_query("SELECT * FROM user WHERE (USER_USERNAME LIKE '%$string%')") 
							or die(mysql_error());
							
							$num_rows = mysql_num_rows($var1);
							if ($num_rows<1)
							{
								echo "<br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
							} else echo "<br/><br/><h2>Resluts found: ".$num_rows."</h2>";
							
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
									<h1> <a href='index.php?action=6&linkOption=".$info['USER_ID']."'>".$info['USER_USERNAME']." </a></h1>
									<p><h3>User details:</h3></p><br/>
									<h3> Name:       ".$info['USER_FN']."</h3>
									<h3> Surname:    ".$info['USER_LN']."</h3>
									<h3> Email:      ".$info['USER_EMAIL']."</h3>
									<h3> Birth Date: ".$info['USER_BIRTH']."</h3><br/>
									";
								if ($userType=="A")
								{
									echo
									"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='userID' type='hidden' id='userID' value='".$info['USER_ID']."'/>
										<input name='user' type='hidden' id='user' value='true'>
										<input type='submit' value='Delete' id='submitButton' name='submitButton'/>
									</form><hr/>
									<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='userID' type='hidden' id='userID' value='".$info['USER_ID']."'/>
										<input name='upgrade' type='hidden' id='upgrade' value='true'>
										<input type='submit' value='Upgrade user' id='submitButton' name='submitButton'/>
									</form><hr/>";
								}
									
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
						} else if ($criteria==9)
						{
							$var1 = mysql_query("SELECT * FROM user WHERE (USER_EMAIL LIKE '%$string%')") 
							or die(mysql_error());
							
							$num_rows = mysql_num_rows($var1);
							if ($num_rows<1)
							{
								echo "<br/><br/><h1> No results </h1><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
							} else echo "<br/><br/><h2>Resluts found: ".$num_rows."</h2>";
							
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
									<h1> <a href='index.php?action=6&linkOption=".$info['USER_ID']."'>".$info['USER_USERNAME']." </a></h1>
									<p><h3>User details:</h3></p><br/>
									<h3> Name:       ".$info['USER_FN']."</h3>
									<h3> Surname:    ".$info['USER_LN']."</h3>
									<h3> Email:      ".$info['USER_EMAIL']."</h3>
									<h3> Birth Date: ".$info['USER_BIRTH']."</h3><br/>
									";
								if ($userType=="A")
								{
									echo
									"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='userID' type='hidden' id='userID' value='".$info['USER_ID']."'/>
										<input name='user' type='hidden' id='user' value='true'>
										<input type='submit' value='Delete' id='submitButton' name='submitButton'/>
									</form>
									<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
										<input name='userID' type='hidden' id='userID' value='".$info['USER_ID']."'/>
										<input name='upgrade' type='hidden' id='upgrade' value='true'>
										<input type='submit' value='Upgrade user' id='submitButton' name='submitButton'/>
									</form><hr/>";
								}
									
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
						}
					}
					?>
		</div>
	</body>
</html>
