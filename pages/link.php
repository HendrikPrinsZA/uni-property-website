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
		$userID = "NoUser";
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
		$option = 99;
	} else
	{
		// session logged 
		$option = $_SESSION['linkOption'];
	}
	
	if(isset($_POST['check1']) && $_POST['check1']=='true')
	{
		if(isset($_POST['rating']))
		{
			$option = $_GET["linkID"];
			$rating = $_POST["rating"];
			$rating = $rating/2;
			if ($rating>0 && $rating<4.5)
			{
				$data = mysql_query("SELECT * FROM rating WHERE (RATING_ID=$option)") 
				or die(mysql_error()); 
				$info = mysql_fetch_array($data);
				
				$score = 0; 
				$nmr = 0;
				
				$score = $info['RATING_SCORE']; 
				$nmr = $info['RATING_TOTAL'];
				
				$nmr = $nmr+1;
				$score = $score *($nmr-1);
				$score = $score + $rating;
				$score = $score / $nmr;
		
				$data = mysql_query("UPDATE rating SET RATING_SCORE=$score,RATING_TOTAL=$nmr WHERE (RATING_ID=$option)") 
				or die(mysql_error()); 
				header("location: ../index.php");
			}
		}
	} else if(isset($_POST['check2']) && $_POST['check2']=='true')
	{
		$option = $_GET["linkID"];
		$comment = $_POST["MyComment"];
		$userID= $_POST["userID"];
		if (strlen($comment)>0)
		{
			$sql = "INSERT INTO comment(COMMENT_DESC,USER_ID,LINK_ID) VALUES('$comment',$userID,$option)";
			if (!mysql_query($sql,$con))
			{
				Print "<h1>That username or password already exists</h1>";
				Print "<h2>Click <a href='index.php?action=10'>here</a> to try again</h2>";
				die;
			}
			header("location: ../index.php");
		}
		echo "LINK_ID=".$option."<br/>";
		echo "USER_ID=".$userID."<br/>";
		echo "COMMENT=".$comment."<br/>";
	}
	
	
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Account </title>
		<script src="js/jquery-1.6.4.min.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" href="css/links.css">
		<link rel="stylesheet" href="css/link.css">
    </head>
    <body>
		<div id="enter">
			<div id="main_menu">
				<ul id="menu">
					<li><a href="#"  name="links" id="links">View Properties</a>
						<ul>
							<li><a href="index.php?action=2&linkOption=1">All Properties</a></li>
							<li><a href="index.php?action=2&linkOption=2">My Properties</a></li>
							<li><a href="index.php?action=2&linkOption=2">For Sale</a></li>
							<li><a href="index.php?action=2&linkOption=2">To Rent</a></li>
							<li><a href="index.php?action=2&linkOption=3">Top Rated</a></li>
						</ul>
					</li>
					<li><a href="#">Categories</a>
						<ul>
							<li><a href="#" target="container">My links</a></li>
							<?php
								$var1 = mysql_query("SELECT * FROM category") 
								or die(mysql_error());
								while($info = mysql_fetch_array( $var1 )) 
								{ 
									Print "<li><a";
									Print " id=".$info['CAT_ID']." title='".$info['CAT_Description']."' href='#'>".$info['CAT_NAME']."</a>"; 
									Print "</li>";
								} 	
							?>
						</ul>
					</li>
					<?php 
						if ($userID>0) 
							echo "	<li><a href='index.php?action=3'  name='nlinks' id='links'>Register new</a>
									</li>"
					?>
				</ul>
			</div>
		
			<div>
				<br/><br/>
				<?php
					$link_user = 0;
					$var1 = mysql_query("SELECT * FROM link,user,rating where (link.LINK_ID=$option) AND (link.USER_ID=user.USER_ID) AND (link.LINK_ID=rating.RATING_ID)") 
					or die(mysql_error());
					while($info = mysql_fetch_array( $var1 )) 
					{ 
						print "<h1 style='text-align:center;'>".$info['LINK_NAME']."</h1>";
						print "<p>".$info['LINK_DESC']."</p><br/>"; 
						//print "<p style='text-align:left;'>Link: <a href=".$info['LINK_URL'].">".$info['LINK_URL']."</a></p>";
						$picLocation = $info['LINK_PIC_LOCATION'];
						$picLocation = 'pages/upload/houses/'.$picLocation;
						
						print "<img src='$picLocation' alt='Logo here' width='680' height='350'/></br>";
						print "<p> Added by: ".$info['USER_USERNAME']."</p>";
						print "<p> Rating: ".$info['RATING_SCORE']."</p>";
						if ($userType=="A")
						{
							echo
							"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
								<input name='ratingID' type='hidden' id='ratingID' value='".$info['RATING_ID']."'/>
								<input name='rating' type='hidden' id='rating' value='true'>
								<input type='submit' value='Reset rating' id='submitButton' name='submitButton'/>
							</form>";
						}
						$link_user = $info['USER_ID'];
					} 
				?>
				<form id='form1' name='form1' method='post' action="pages/link.php?linkID=<?php echo $option ?>">
					<div class="stars">
					  <label for="rating-1"><input id="rating-1" name="rating" type="radio" value="1"/>0.5 Stars</label>
					  <label for="rating-2"><input id="rating-2" name="rating" type="radio" value="2"/>1 Star</label>
					  <label for="rating-3"><input id="rating-3" name="rating" type="radio" value="3"/>1.5 Stars</label>
					  <label for="rating-4"><input id="rating-4" name="rating" type="radio" value="4"/>2 Stars</label>
					  <label for="rating-5"><input id="rating-5" name="rating" type="radio" value="5"/>2.5 Stars</label>
					  <label for="rating-6"><input id="rating-6" name="rating" type="radio" value="6"/>3 Stars</label>
					  <label for="rating-7"><input id="rating-7" name="rating" type="radio" value="7"/>3.5 Stars</label>
					  <label for="rating-8"><input id="rating-8" name="rating" type="radio" value="8"/>4 Stars</label>
					</div>
					<div>
					  <input type="submit" value="Submit Rating" />
					  <input name="check1" type="hidden" id="check1" value="true"/>
					</div>
				</form>
				<?php
					$var1 = mysql_query("SELECT * FROM comment,user WHERE (comment.LINK_ID=$option) AND (user.USER_ID=comment.USER_ID)") 
					or die(mysql_error());
					print "<hr/>";
					$counter = 0;
					while($info = mysql_fetch_array( $var1 )) 
					{ 
						$counter++;
						print "<div class='comment'>";
							print "<a> Comment nmr: ".$counter."</a>";
							print "<p>".$info['COMMENT_DESC']."</p><br/>";
							print "<a> By user: ".$info['USER_USERNAME']."</a>";
							if ($userType=="A" || $info['USER_ID']==$userID)
							{
								echo
								"<form id='theForm' name='theForm' method='post' action='index.php?action=8'>
									<input name='commentID' type='hidden' id='commentID' value='".$info['COMMENT_ID']."'/>
									<input name='comment' type='hidden' id='comment' value='true'>
									<input type='submit' value='Delete' id='submitButton' name='submitButton'/>
								</form>";
							}
						print "</div><hr/>";
					}
					//mysql_close($con);
				?>
				<form id='form2' name='form2' method='post' action="pages/link.php?linkID=<?php echo $option ?>">
					<br/><label>Post new comment<br/><br/></label><br/>
						<div style="display: block;">
							<div class="textwrapper">
								<textarea cols="50" rows="5" name='MyComment' id='MyComment' placeholder="Write your comment here..." required></textarea>
							</div>
						</div>
						<br/><br/><br/><br/><br/><br/>
					<input name="userID" type="hidden" id="userID" value="<?php echo $userID?>"/>
					<input name="check2" type="hidden" id="check2" value="true"/>
					<?php
						if ($link_user>0)
						{
							$var1 = mysql_query("	SELECT * FROM user WHERE (USER_ID=$userID) AND (USER_ID IN(SELECT USER_ID FROM user where user_id IN(SELECT friend_ID AS one FROM friend WHERE (user_ID=$link_user) AND (friend_status='A')
													UNION
													SELECT user_ID AS one FROM friend WHERE friend_ID=$link_user AND (friend_status='A'))
													ORDER BY user_username))")
							or die(mysql_error());
							$num_rows1 = mysql_num_rows($var1);
							if ($num_rows1>0 || $userID==$link_user)
							{
								echo "<input type='submit' value='Post Comment'/>";
							}
						}
					?>
					</p>
				</form>
			</div>
		</div>
	</body>
</html>