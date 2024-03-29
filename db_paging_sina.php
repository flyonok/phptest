<!DOCTYPE HTML>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
 <?php
// Adam's Custom PHP MySQL Pagination Tutorial and Script
// You have to put your mysql connection data and alter the SQL queries(both queries)
// This script is in tutorial form and is accompanied by the following video:
// http://www.youtube.com/watch?v=K8xYGnEOXYc
// mysql_connect("DB_Host_Here","DB_Username_Here","DB_Password_Here") or die (mysql_error());
// mysql_select_db("DB_Name_Here") or die (mysql_error());
//////////////  QUERY THE MEMBER DATA INITIALLY LIKE YOU NORMALLY WOULD
// $sql = mysql_query("SELECT id, firstname, country FROM myTable ORDER BY id ASC");
$dir = "sqlite:sina.db";
$dbh  = new PDO($dir) or die("cannot open the database");
$query =  "SELECT count(*) from Article";
//////////////////////////////////// Adam's Pagination Logic ////////////////////////////////////////////////////////////////////////
foreach ($dbh->query($query) as $row) {
$nr = (int)$row[0];
// $nr = mysql_num_rows($sql); // Get total of Num rows from the database query
}
if (isset($_GET['pn'])) { // Get pn from URL vars if it is present
    $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    //$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
} else { // If the pn URL variable is not present force it to be value of page number 1
    $pn = 1;
}
//This is where we set how many database items to show on each page
$itemsPerPage = 10;
// Get the value of the last page in the pagination result set
$lastPage = ceil($nr / $itemsPerPage);
// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
}
// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
}
// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;
// Now we are going to run the same query as above but this time add $limit onto the end of the SQL syntax
// $sql2 is what we will use to fuel our while loop statement below
// $sql2 = mysql_query("SELECT id, firstname, country FROM myTable ORDER BY id ASC $limit");
$sql2 = "select * from Article ORDER BY _id DESC " . $limit ;
// echo $sql2 . "<br/>";
// die("exit");
//////////////////////////////// END Adam's Pagination Logic ////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Adam's Pagination Display Setup /////////////////////////////////////////////////////////////////////
$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= 'Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '"> Back</a> ';
    }
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '"> Next</a> ';
    }
}
///////////////////////////////////// END Adam's Pagination Display Setup ///////////////////////////////////////////////////////////////////////////
// Build the Output Section Here
//$outputList = '';
//while($row = mysql_fetch_array($sql2)){
//
//    $id = $row["id"];
//    $firstname = $row["firstname"];
//    $country = $row["country"];
//
//    $outputList .= '<h1>' . $firstname . '</h1><h2>' . $country . ' </h2><hr />';
//   
//} // close while loop
$outputList = '';
foreach ($dbh->query($sql2) as $row) {
	// echo "<tr>";
	$outputList .= "<tr>";
	// echo "<td><a href=\"content.php?URL=".$row['orgURL']."\">".$row['Title']."</a></td>";
	$outputList .= "<td class=\"column\"><a href=\"content_sina.php?URL=".$row['oriUrl']."\"" . " target=\"mycontent\" >".$row['theTitle']."</a></td>";
    $outputList .= "<td id=\"orig\">" ."<a href=\"".$row['oriUrl']."\"". " target=\"original\" >". $row['oriUrl'] . "</td>";
	$outputList .= "</tr>";
}
?>
<html>
<head>
<title>新浪新闻分页</title>
<style type="text/css">

.pagNumActive {
    color: #000;
    border:#060 %1 solid; background-color: #D2FFD2; padding-left:%1; padding-right:%1;
}
.paginationNumbers a:link {
    color: #000;
    text-decoration: none;
    border:#999 %1 solid; background-color:#F0F0F0; padding-left:%1; padding-right:%1;
}
.paginationNumbers a:visited {
    color: #000;
    text-decoration: none;
    border:#999 %1 solid; background-color:#F0F0F0; padding-left:%1; padding-right:%1;
}
.paginationNumbers a:hover {
    color: #000;
    text-decoration: none;
    border:#060 %1 solid; background-color: #D2FFD2; padding-left:%1; padding-right:%1;
}
.paginationNumbers a:active {
    color: #000;
    text-decoration: none;
    border:#999 %1 solid; background-color:#F0F0F0; padding-left:%1; padding-right:%1;
.data {
	width:auto;
	
}
body {
font: normal 100% Helvetica, Arial, sans-serif;
}
@media screen and (max-device-width: 400px) {
.column {
float: none;
width:auto;
}
#orig {
display:none;
}
}
</style>
</head>
<body>
   <div style="margin-left:%4; margin-right:%4;">
     <h2>Total Items: <?php echo $nr; ?></h2>
   </div>
    <div id="content">
      <div style="margin-left:%3; margin-right:%3; padding:%2; background-color:#FFF; border:#999 %1 solid;"><?php echo $paginationDisplay; ?></div>
     
      <!-- <table border="1" width="100%"> -->
      <table style="margin-left:%3; margin-right:%3; padding:%2; background-color:#FFF; border:#999 %1 solid;" border="1">
	  <th width="20%">标题</th>
      <th width="30%">查看原文</th>
      <div style="margin-left:%4; margin-right:%4;"><?php print "$outputList"; ?></div>
      </table>
      <div style="margin-left:%3; margin-right:%3; padding:%2; background-color:#FFF; border:#999 %1 solid;"><?php echo $paginationDisplay; ?></div>
      </div> <!-- content -->
</body>
</html>
