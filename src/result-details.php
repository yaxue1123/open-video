<html>

<?php
require "dbconnect.php";
// acquire video id by $_POST variable
// sanitize the vid to int to prevent potential error
$vid = filter_var($_POST['vid'], FILTER_SANITIZE_NUMBER_INT);
// search records by video id
$query_search = "SELECT * FROM p2records WHERE videoid='" . $vid . "'";
if ($result = $mysqli->query($query_search)) {
    while ($row = $result->fetch_assoc()) {
        // display sanitized results in formatted style
        echo "<strong>" . htmlentities(strip_tags($row['title'])) . "</strong><br><br>";
        echo "<strong>Genre:</strong>" . htmlentities(strip_tags($row['genre'])) . "<br>";
        echo "<strong>Keywords:</strong>" . htmlentities(strip_tags($row['keywords'])) . "<br>";
        echo "<strong>Duration:</strong>" . htmlentities(strip_tags($row['duration'])) . "<br>";
        echo "<strong>Color:</strong>" . htmlentities(strip_tags($row['color'])) . "<br>";
        echo "<strong>Sound:</strong>" . htmlentities(strip_tags($row['sound'])) . "<br>";
        echo "<strong>Sponsor:</strong>" . htmlentities(strip_tags($row['sponsorname'])) . "<br>";

    }
}

?>
</html>
