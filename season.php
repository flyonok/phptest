<!DOCTYPE html5">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
if (!$_GET['id']) {
	die("id parameter is null!");
}
$id = htmlspecialchars($_GET['id']);
$sql = "select _id, seasonTitle from Season where novelId = '" . $id ."'";
// echo $sql;
$dir = 'sqlite:xxtebook.db';
$dbh  = new PDO($dir) or die("cannot open the database");
$list = "";
$seasonTitle = "";
$id = "";
// $title = "";
foreach ($dbh->query($sql) as $row) {
	// echo htmlspecialchars($row['Html']);
	// echo html_entity_decode(iconv('utf-8','gbk',$row['content']));
	 // echo html_entity_decode($row['content']);
	// echo iconv('utf-8','gbk',html_entity_decode($row['content']));
	$id = $row['_id'];
	$seasonTitle = $row['seasonTitle'];
	$list .= "<li> <a href = \"db_paging.php?id=". $id. "&title=". $seasonTitle. "\"". " target=\"mypage\">". $seasonTitle. "</a>". "</li>";
	
	// $title = $row['theTitle'];
	// break;
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>应用分类</title>
</head>
<style type="text/css">
img { max-width: 100%;}
.data {
width:auto;
}
body {
font: normal 100% Helvetica, Arial, sans-serif;
}


</style>

<body>
<div id="display_content">
<ul>
<?php print $list; ?>
</ul>
</div>
</body>
</html>