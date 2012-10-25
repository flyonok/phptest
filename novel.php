<!DOCTYPE HTML>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php
	$dir = 'sqlite:xxtebook.db';
	$dbh  = new PDO($dir) or die("cannot open the database");
	$sql = "select _id, novelTitle, year from novel";
	$outputList = "";
	foreach ($dbh->query($sql) as $row) {
		$id = $row["_id"];
		$title = $row["novelTitle"];
		$date = $row["year"];
		$outputList .= "<tr>" ;
		$outputList .= "<td> <a href = \"season.php?id=". $id. "\"". " target=\"myseason\">". $title. "</a></td>";
		$outputList .= "<td>" . $date ."</td>";
		$outputList .= "</tr>" ;
	}
?>
<html>
<head>
<title>应用表</title>
<head>
<body>
 <table style="margin-left:%3; margin-right:%3; padding:%2; background-color:#FFF; border:#999 %1 solid;" border="1">
	  <th width="20%">应用名称</th>
      <th width="30%">建立时间</th>
      <div style="margin-left:%4; margin-right:%4;"><?php print "$outputList"; ?></div>
 </table>
</body>
</html>
