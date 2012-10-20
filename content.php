<!DOCTYPE html5">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
if (!$_GET['URL']) {
	die("URL parameter is null!");
}
$url = htmlspecialchars($_GET['URL']);
$sql = "select theTitle, content from Article where oriUrl = '" . $url ."'";
// echo $sql;
$dir = 'sqlite:xxtebook.db';
$dbh  = new PDO($dir) or die("cannot open the database");
$content = "";
$title = "";
foreach ($dbh->query($sql) as $row) {
	// echo htmlspecialchars($row['Html']);
	// echo html_entity_decode(iconv('utf-8','gbk',$row['content']));
	 // echo html_entity_decode($row['content']);
	// echo iconv('utf-8','gbk',html_entity_decode($row['content']));
	$content = $row['content'];
	$title = $row['theTitle'];
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php print $title ?></title>
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
<?php print $content; ?>
</div>
</body>
</html>