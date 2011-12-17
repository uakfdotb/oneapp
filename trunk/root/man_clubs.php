<html>
<body>

<?php
include("header.php");
include("../config.php");
include("../include/common.php");
include("../include/db_connect.php");
include("../include/session.php");

if(isset($_SESSION['root'])) {
    if(isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];
        
        if($action == 'add_club') {
            $username = escape($_REQUEST['name']);
            $password = escape($_REQUEST['pass']);
            
            mysql_query("INSERT INTO admins (name, pass) VALUES ('$username', '$password')");
            echo "Admin added successfully! Click <a href=\"man_club.php\">here</a> to continue.";
        } else if($action == 'delete') {
            $club_id = escape($_REQUEST['id']);
            mysql_query("DELETE FROM clubs WHERE id='$club_id'");
            echo "Club deleted successfully! Click <a href=\"man_clubs.php\">here</a> to continue.";
        }
    } else {
        $result = mysql_query("SELECT id,name,description FROM clubs");
        
        echo '<form action="man_club.php?action=add_club" method="post">Club name<input type="text" name="name"><br>Description<br><textarea name="description">';
        echo '<br><input type="submit" value="Add club"></form>';
        echo "<table><tr><th>Club name</th><th>Description</th><th>Edit</th><th>Delete</th></tr>";
        
        while($row = mysql_fetch_array($result)) {
            echo "<tr><td>" . $row['name'] . "</td>";
            
            echo "<form method=\"post\" action=\"man_clubs.php?action=update\">";
            echo "<td><textarea name=\"description\">" . $row['description'] . "</textarea></td>";
            echo "<td><input type=\"submit\" value=\"Update\"></td></form>";
            
            echo "<form method=\"post\" action=\"man_clubs.php?action=delete\">";
            echo "<td><input type=\"submit\" value=\"Delete\"></td></form>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
}
?>

</body>
</html>
