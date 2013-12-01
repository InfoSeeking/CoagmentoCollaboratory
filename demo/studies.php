<?php
	 require_once('../core/User.class.php');
	 require_once('../core/Session.class.php');
	 require_once("../core/Stage.class.php");
	 require_once("../core/Action.class.php");
	 require_once("../core/Snippet.class.php");
	 require_once("../core/Project.class.php");
	 require_once("../core/Bookmark.class.php");
	 require_once("../core/Page.class.php");

	 $output = array(0 => "", 1 => ""); //0 for individual, 1 for group
	 //get all projects
	 $projects = Project::retrieveAll();
	 foreach($projects as $proj){
	 	//get users from this project
	 	$pid = $proj->getProjectID();
	 	$users = User::retrieveUsersFromProject($pid);
	 	echo $pid;
	 	$type = 0;
	 	if(sizeof($users) > 1){
	 		$type = 1; //group
	 	}

	 	
	 	$output[$type] .= "<h2>" . $proj->getTitle() . "</h2>";
	 	if($type == 0){
	 		$output[$type] .= "<h3>Member</h3>";
	 	}
	 	else{
	 		$output[$type] .= "<h3>Members</h3>";
	 	}
	 	foreach($users as $u){
	 		$uid = $u->getUserID();
	 		//get bookmarks
	 		$bookmarks = Bookmark::retrieveFromUser($uid, $pid);
	 		//get snippets
	 		$snippets = Snippet::retrieveFromUser($uid, $pid);
	 		//get pages
	 		$pages = Page::retrieveFromUser($uid, $pid);

	 		$output[$type] .= "<h4>" . $u->getUserName() . "</h4>";
	 		$output[$type] .= "<div class='memberinfo'><div><h5>Pages Visited</h5>";
	 		foreach($pages as $p){
	 			$output[$type] .= "<p>" . $p->getUrl() . "</p>";
	 		}
	 		$output[$type] .= "</div><div><h5>Bookmarks Collected</h5>";
	 		foreach($bookmarks as $b){
	 			$output[$type] .= "<p>" . $b->getUrl() . "</p>";
	 		}
	 		$output[$type] .= "</div><div><h5>Snippets Collected</h5>";
	 		foreach($snippets as $s){
	 			$output[$type] .= "<p>" . $s->getSnippet() . "</p>";
	 		}
	 		$output[$type] .= "</div>";
	 	}
	 }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Demo of Individual and Group Studies</title>
  <meta name="description" content="">
  <meta name="author" content="">
  <style type="text/css">

  </style>

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body>
	<h1>Individual Studies</h1>
	<?php
		echo $output[0];
	?>
	<h1>Group Studies</h1>
	<?php
		echo $output[1];
	?>
</body>
</html>