<h1>Database</h1>
<p>A complete listing of the tables in the database are in the db/data folder. Be sure to set your username, password, and host in the core/config.php file before importing these tables</p>

<?php
require_once("../core/config.php");
//PDO does not play well with creating tables
$cxn = mysqli_connect($DB_SETTINGS['host'], $DB_SETTINGS['user'], $DB_SETTINGS['password'], $DB_SETTINGS['database']) or die("Cannot connect to database, edit the file: core/config.php and put in your credentials");

$DATA_DIR = opendir("data");

$tables = Array();

while($f = readdir($DATA_DIR)){
	if(substr($f, strlen($f) - 3) == "sql"){
		array_push($tables, substr($f, 0, strlen($f) - 4));
	}
}

if(isset($_POST['create_table'])):
	foreach($tables as $t){
		if(isset($_POST[$t])){
			//create the table
			$query = file_get_contents("data/" . $t . ".sql");
			mysqli_query($cxn, $query) or die("Could not create table " . $t);
		}
	}
	echo "Tables created";
else:
?>

<button id="select">Deselect All</button>
<form action="#" method="post">

<?php
/* show options */
foreach($tables as $t){
	echo "<input name='$t' type='checkbox' id='t_$t' checked/><label for='t_$t'>$t</label><br/>";
}
//mysqli_query($cxn, $data) or die(mysqli_error($cxn));
?>
<input type="hidden" name="create_table" value="yes" />
<input type="submit" value="Create Tables" />
</form>

<script src="../demo/jquery-1.10.2.min.js"></script>
<script>
var d = true;
$("#select").click(function(){
	if(d){
		$("input[type=checkbox]").prop("checked", false);
		$(this).html("Select All");
	}
	else{
		$("input[type=checkbox]").prop("checked", true);
		$(this).html("Deselect All");
	}
	d = !d;
});
</script>
<?php endif; ?>