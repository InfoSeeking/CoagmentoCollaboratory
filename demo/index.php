<?php
	 session_start();
	 require_once('../core/User.class.php');
	 require_once('../core/Session.class.php');
	 
	if (($_POST['userName'])&&(!Session::getInstance()->isSessionActive()))
	{
		$userName = $_POST['userName'];
		$password = sha1($_POST['password']); //Try to use sha1, MD5 or other in the client side with javascript so that password does not come.
		try
		{
			$user = User::login($userName,$password);
			if ($user!=null)
			{
				Session::getInstance()->user = $user;
				//echo "UserID:".$user->getUserID();
				//header("Location: http://www.google.com");
				echo "A session has been created";
			}
			else
				echo "User name and password do not match or user does not exist";
		}
		catch(Exception $e)
		{
			echo "An unexcepted error has occurred Code".$e->getCode();
		}
	}
	else 
	{
		if (!Session::isSessionActive())
		{
?>
	<html>
		<head>
			<title>Login</title>
		<head>
		<script type="text/javascript">
			function validate(form)
			{
		          /*Capturing client time. It may be a good idea if planning to synchronize 
				  log data with other sources of data captured at the client side: e.g. video, eye tracking, etc. */
		          var currentTime = new Date();
		          var month = currentTime.getMonth() + 1; //getMonth retunrs values from 0 to 11.
		          var day = currentTime.getDate();
		          var year = currentTime.getFullYear();
		          var clientDate = year + "/" + month + "/" + day;
		          var hours = currentTime.getHours();
		          var minutes = currentTime.getMinutes();
		          var seconds = currentTime.getSeconds();
		          var clientTime = hours + ":" + minutes + ":" + seconds;
		          var clientTimestamp = currentTime.getTime();
		          
		          document.getElementById("clientTimestamp").value = clientTimestamp;
		          document.getElementById("clientDate").value = clientDate;
		          document.getElementById("clientTime").value = clientTime;

		          return true;
			} 	 
		</script>		
<?php 
			echo "<body>\n<center>\n<br/><br/>\n";
			echo "<form action=\"index.php\" method=\"post\" onsubmit=\"return validate(this)\">\n";
			echo "<br/><br/>\n<table class=body>\n";
			echo "<tr><td>Username</td><td>&nbsp;&nbsp; <input type=\"text\" name=\"userName\" size=20 /></td></tr>\n";
			echo "<tr><td>Password</td><td>&nbsp;&nbsp; <input type=\"password\" name=\"password\" size=20 /></td></tr>\n";
			echo "<tr><td colspan=\"2\"><br/></td></tr>\n";
			echo "<tr><td colspan=\"2\" align=center><input type=\"hidden\" id=\"clientTimestamp\" name=\"clientTimestamp\" value=\"\"/><input type=\"hidden\" id=\"clientTime\" name=\"clientTime\" value=\"\"/><input type=\"hidden\" id=\"clientDate\" name=\"clientDate\" value=\"\"/><input type=\"submit\" value=\"Submit\"/></td></tr>\n";
			echo "</table>\n";
			echo "</form>\n";				
			echo "</body></html>";
		}
		else
		{
			//$stage = new Stage();
			//$page = $stage->getCurrentPage();			
			echo "A session is currently active";
			//header("Location: http://www.google.com");
		}
	}
?>
