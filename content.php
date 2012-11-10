<!DOCTYPE html5">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
define('ALLIMAGE', 10);
if (!$_GET['URL']) {
	die("URL parameter is null!");
}
$url = htmlspecialchars($_GET['URL']);
$sql = "select theTitle, content, artType, resList from Article where oriUrl = '" . $url ."'";
// echo $sql;
$dir = 'sqlite:xxtebook.db';
$dbh  = new PDO($dir) or die("cannot open the database");
$content = "";
$title = "";
$imgHtml = "<table>";
$echoImage = "";
foreach ($dbh->query($sql) as $row) {
	// echo htmlspecialchars($row['Html']);
	// echo html_entity_decode(iconv('utf-8','gbk',$row['content']));
	 // echo html_entity_decode($row['content']);
	// echo iconv('utf-8','gbk',html_entity_decode($row['content']));
	$content = $row['content'];
	$title = $row['theTitle'];
  if ($row['artType'] == ALLIMAGE) {
    $echoImage = '1';
    processJson($row['resList']);
  }
}
$imgHtml .= "</table>";
function processImage($imageArr)
{
  foreach ($imageArr as $id) {
    $imgSql = "select resContent from Resource where _id = " . $id;
    // var_dump($imgSql);
    foreach ($GLOBALS['dbh']->query($imgSql) as $imgRow) {
      $GLOBALS['imgHtml'] .= "<tr><td><img src=\"";
      $GLOBALS['imgHtml'] .= $imgRow['resContent'];
      $GLOBALS['imgHtml'] .= "\"/>";
      // $GLOBALS['imgHtml'] .= "\">";
      $GLOBALS['imgHtml'] .= "</td></tr>";
    }
  }
  // var_dump($imgHtml);
}
function processJson($imageJson)
{
  $imgObj = json_decode($imageJson);
  // var_dump($imgObj);
  if (is_array($imgObj->{'bh'})) {
    // var_dump($imgObj->{'bh'});
    processImage($imgObj->{'bh'});
  }
  if (is_array($imgObj->{'bv'})) {
    processImage($imgObj->{'bv'});
  }
  if (is_array($imgObj->{'sh'})) {
    processImage($imgObj->{'sh'});
  }
  if (is_array($imgObj->{'sv'})) {
    processImage($imgObj->{'sv'});
  }
  if (is_array($imgObj->{'res'})) {
    procesImage($imgObj->{'res'});
  }
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
<?php 
  print $content;
  print "<br/>";
  if ($echoImage == '1') {
    print $imgHtml;
  }
?>
</div>
</body>
</html>