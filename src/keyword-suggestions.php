<?php
require "dbconnect.php";

// sanitize user input by addslashes to prevent MySQL injection
// only select maximum of 10 suggested words using LIKE
$query_search = "SELECT * FROM p2suggestion WHERE word LIKE '" . addslashes($_GET['input']) . "%' LIMIT 10";

if ($result = $mysqli->query($query_search)) {
    while ($row = $result->fetch_assoc()) {
        // display each record of word with style
        echo "<a class='sg'>" . $row['word'] . "</a><br>";
    }
}

?>

