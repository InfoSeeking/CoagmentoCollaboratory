<?php
	 session_start();
	 require_once('../core/User.class.php');
	 require_once('../core/Session.class.php');
	 require_once("../core/Stage.class.php");
	 
	if (($_POST['userName'])&&(!Session::getInstance()->isSessionActive())):
		$userName = $_POST['userName'];
		$password = sha1($_POST['password']);
		try
		{
			$user = User::login($userName,$password);
			if ($user!=null)
			{
				Session::getInstance()->user = $user;
				echo "A session has been created";
			}
			else
				echo "User name and password do not match or user does not exist";
		}
		catch(Exception $e)
		{
			echo "An unexcepted error has occurred Code".$e->getCode();
		}
	else:
		if (!Session::isSessionActive()):
?>
	<html>
	<head>
		<title>Login</title>
	<head>	
	<body>
		<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="main.js"></script>
		<form action="index.php" method="post" class="addTimestamps">	
			<label>Username</label><input type="text" name="userName" size=20 /><br/>
			<label>Password</label><input type="password" name="password" size=20 /><br/>
			<input type="submit" value="Submit"/>
		</form>	
	</body></html>
<?php
		
		else:
		
			$stage = new Stage();
			$page = $stage->getCurrentPage();	
			echo "Stage page: " . $page;		
			echo "A session is currently active";
			//header("Location: http://www.google.com");
		endif;
	endif;
?>
