<?php
require "dbconnect.php";
// check if the user is logged in, if not, jump to login page
if (isset($_SESSION['valid_user'])) {
$username = $_SESSION['valid_user'];
// sanitize the username since it will be displayed on page
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Video</title>
    <link rel="Shortcut Icon" href="logo.jpg">
    <link rel='stylesheet' href='style.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Oxygen|Poiret%20One|Roboto|Jua'>
    <script>
        // when the DOM is ready, execute the JQuery code
        $(document).ready(function () {

            $("#inputVal").keyup(function () {
                // when typing in the search-box character by character
                // send characters typed so far through GET parameter to keyword-suggestions.php
                $.get("keyword-suggestions.php?input=" + $("#inputVal").val(),
                    function (data, status) {
                        // display query suggestion results to #l2 div
                        $("#l2").html(data)
                    })
            });

            $("#bt").click(function () {
                // when clicking the search button
                // change the url of current window so that GET parameter can get search word
                window.location = "results.php?search=" + document.getElementById("inputVal").value
            });

            $(".trow").mouseover(function () {
                // when mousing over the search result area
                // send videoid to result-details.php
                var videoid = $(this).attr('videoid')
                $.post("result-details.php",
                    {vid: videoid},
                    function (data, status) {
                        // display details to #right element
                        $("#right").html(data)
                    })
            });

            $(".trow").mouseleave(function () {
                // to prompt users to hover and see details
                $("#right").text("Hover to see details.")
            });
        });

    </script>
</head>

<body>
<header>
    <div class="bground">
        <div class="background-caption">
            <h1>Open Video</h1>
            <h2>Hello, <?php echo htmlentities(strip_tags($username)); ?>. Find more in the video world.</h2>
        </div>
    </div>
</header>

<div id="navbar">
    <a class="active" href="https://opal.ils.unc.edu/~yaxue/yaxue_p2/results.php">Home</a>
    <a href="logout.php">Logout</a>
</div>


<div class="container">
    <aside id="left">
        <div class="search-area">
            <form id="l1" action="results.php" method="get">
                <input type="text" placeholder="Search" name="searchby" id="inputVal">
                <button type="button" value="Search" id="bt">Search</button>
            </form>
        </div>
        <div class="suggestion-area">
            <p>Suggestions:</p>
            <div class="suggestion" id="l2">
            </div>
        </div>
    </aside>
    <section id="middle">
        <p>Showing results for:
            <?php
            // clean the user input and redisplay on the web page
            if(isset($_GET['search']))
                 echo htmlentities(strip_tags($_GET['search']));
            ?>
        </p>
        <table>
            <?php
            // sanitize user input
            if(isset($_GET['search'])){
                $searchby = addslashes($_GET['search']);
                $query_search = "SELECT * FROM p2records WHERE MATCH (title,description,keywords) AGAINST ('" . $searchby . "')";}
            else {
                $query_search = "SELECT * FROM p2records";}
            
            if ($result = $mysqli->query($query_search)) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='trow' videoid='" . $row['videoid'] . "'><td rowspan='2'><a href='http://www.open-video.org/details.php?videoid=" . $row['videoid'] . "'>" . "<img src='http://www.open-video.org/surrogates/keyframes/" . $row['videoid'] . "/" . $row['keyframeurl'] . "'>" . "</a></td>";
                    echo "<td class='trow' videoid='" . $row['videoid'] . "'><a href='http://www.open-video.org/details.php?videoid=" . $row['videoid'] . "'>" . $row['title'] . "(" . $row['creationyear'] . ")</a></td></tr>";
                    echo "<tr><td>" . substr($row["description"], 0, 200) . "</td></tr>";
                }
            }
            ?>
        </table>
    </section>
    <aside id="right">
        <p>Details of result:</p>
    </aside>
</div>

<footer>
    © 2018 Yaxue Guo
</footer>
<script>
    // when the user scrolls the page, execute stick function
    window.onscroll = function () {
        stick()
    };
    // get the navbar and right aside
    var navbar = document.getElementById("navbar");
    var right = document.getElementById("right");
    // get the offset position of the navbar
    var sticky = navbar.offsetTop;

    function stick() {
        // change sticky style for navbar and right aside based on the navbar's position
        if (window.pageYOffset >= sticky) {
            // when the navbar is on the right top, keep navbar and right aside fixed
            navbar.classList.add("sticky")
            right.classList.add("right-sticky")
        } else {
            // when the navbar is below the top, un-stick the navbar and right aside
            navbar.classList.remove("sticky")
            right.classList.remove("right-sticky")
        }
    }
</script>
<?php

} // if no active session, ask for the user to log in
else {
    // if the user hasn't logged in but directly input url to access the result page, redirect the user to login page
?>
   <script> window.location.href="http://photochemcad.com/openvideo/login.php";</script>
<?php
    exit;
}
?>
</body>
</html>
