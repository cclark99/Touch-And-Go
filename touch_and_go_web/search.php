<?php

$connection = new mysqli('localhost', 'test', 'test123', 'touch_and_go_test');

$search = $_GET['search'];
$search = $mysqli -> real_escape_string($search);

$query = "SELECT * FROM student WHERE studentFirstName LIKE '%".$search."%'";
$result= $mysqli -> query($query);

while($row = $result -> fetch_object()){
    echo "<div id='link' onClick='addText(\"".$row -> studentFirstName."\");'>" . $row -> studentFirstName . "</div>";  
}

?>