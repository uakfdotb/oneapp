<?php
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

get_root_header();

if(isset($_SESSION['root'])) {
?>

<form action="man_pages.php" method="post">
<select name="page">

<?
if(isset($_REQUEST['page'])) {
        $selectedPage = $_REQUEST['page'];
} else {
        $selectedPage = 0;
}

$result = mysql_query("SELECT name FROM pages");
while($row = mysql_fetch_array($result)) {
        $pageName = $row[0];

        $selectedString = "";
        if($selectedPage == $pageName) {
                $selectedString = " selected";
        }

        echo "<option value=\"$pageName\"$selectedString>$pageName</option>";
}
?>

</select>
<input type="submit" name="action" value="Edit">
<input type="submit" name="action" value="Delete">
</form><br><br>
 
<?
   if(isset($_REQUEST['action']) && isset($_REQUEST['page'])) {
    	$page = $_REQUEST['page'];
    	
    	if($_REQUEST['action'] == "Edit") {
			if(isset($_REQUEST['contents'])) {
				savePage($page, $_REQUEST['contents']);
			}
			
			$contents = page_db_part($page);
			echo '<table width=100%><tr><form method="post" action="man_pages.php?action=Edit&page=' . $page . '"><textarea name="contents" rows="20" cols="80" style="resize:none;width:100%">' . $contents . '</textarea><input type="submit" value="Update"></form></tr></table><br><br>';
		} else if($_REQUEST['action'] == "Delete") {
			deletePage($page);
		} else if($_REQUEST['action'] == "add") {
			savePage($page, "");
		}
    }

?>

<form action="man_pages.php?action=add" method="post">
<p class="messpar">Page name <input type="text" name="page">
<input type="submit" value="Add">
</form></p>

<?
}
get_root_footer();
?>
