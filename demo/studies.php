<?php
	 require_once('../core/User.class.php');
	 require_once('../core/Session.class.php');
	 require_once("../core/Stage.class.php");
	 require_once("../core/Action.class.php");
	 require_once("../core/Snippet.class.php");
	 require_once("../core/Project.class.php");
	 require_once("../core/Bookmark.class.php");
	 require_once("../core/Page.class.php");

	 function shorten($txt, $maxC=25){
	 	if(strlen($txt) > $maxC){
			$txt = substr($txt, 0, $maxC) . "...";
		}
		return $txt;
	 }
	 $output = array(0 => "", 1 => ""); //0 for individual, 1 for group
	 //get all projects
	 $projects = Project::retrieveAll();
	 foreach($projects as $proj){
	 	//get users from this project
	 	$pid = $proj->getProjectID();
	 	$users = User::retrieveUsersFromProject($pid);
	 	$type = 0;
	 	if(sizeof($users) > 1){
	 		$type = 1; //group
	 	}

	 	
	 	$output[$type] .= "<h2>" . $proj->getTitle() . "</h2>";
	 	foreach($users as $u){
	 		$uid = $u->getUserID();
	 		//get bookmarks
	 		$bookmarks = Bookmark::retrieveFromUser($uid, $pid);
	 		//get snippets
	 		$snippets = Snippet::retrieveFromUser($uid, $pid);
	 		//get pages
	 		$pages = Page::retrieveFromUser($uid, $pid);

	 		$output[$type] .= "<h3>Username: " . $u->getUserName() . "</h3>";
	 		$output[$type] .= "<div class='memberinfo cf'><div><h5>Pages Visited</h5><table cellspacing=0>";
	 		
	 		foreach($pages as $p){
	 			$url = $p->getUrl();
	 			$short = shorten($url);
	 			$output[$type] .= sprintf("<tr><td><a href='%s' target='_blank'>%s</a></td><td>%s</td><td>%s</td></tr>", $url, $short, $p->getStartDate(), $p->getStartTime());
	 		}
	 		$output[$type] .= "</table></div><div><h5>Bookmarks Collected</h5><table cellspacing=0>";
	 		foreach($bookmarks as $b){
	 			$url = $b->getUrl();
	 			$short = shorten($url, 30);
	 			$output[$type] .= sprintf("<tr><td><a href='%s' target='_blank'>%s</a></td></tr>", $url, $short);
	 		}
	 		$output[$type] .= "</table></div><div><h5>Snippets Collected</h5><table cellspacing=0>";
	 		foreach($snippets as $s){
	 			$short = shorten($s->getSnippet(), 30);
	 			$output[$type] .= sprintf("<tr><td>%s</td></tr>", $short);
	 		}
	 		$output[$type] .= "</table></div></div>";
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
	*{
		margin: 0;
		padding: 0;
		font-family: "Open Sans", "Arial";
	}
	.cf:before,
	.cf:after {
	    content: " "; /* 1 */
	    display: table; /* 2 */
	}

	.cf:after {
	    clear: both;
	}
	.cf {
	    *zoom: 1;
	}
	p, td{
		font-size: 10px;
	}
	.memberinfo{
		padding-bottom: 5px;
		border-bottom: 5px black solid;
		margin-bottom: 10px;
	}
	.memberGroup .memberinfo:last-child{
		border-bottom: none;
	}
	.memberinfo div{
		width: 300px;
		float: left;
	}
	.memberinfo table{
		width: 290px;
	}
	.memberinfo table td{
		padding: 2px;
	}
	.memberinfo table tr:nth-child(odd) td{
		background: #B5E5FF;
	}
	#container{
		width: 900px;
		margin: 0px auto;
	}
	h1{
		width: 100%;
		border-bottom: 10px black solid;
	}
	h3{
		margin-bottom: 10px;
	}
	h5{
		margin-bottom: 5px;
	}
	a{
		color: #000;
	}
  </style>

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body>
<div id="container">
	<h1>Individual Studies</h1>
	<div class="memberGroup">
		<?php
			echo $output[0];
		?>
	</div>
	<div class="ruler"></div>
	<h1>Group Studies</h1>
	<div class="memberGroup">
		<?php
			echo $output[1];
		?>
	</div>
</div>
</body>
</html>