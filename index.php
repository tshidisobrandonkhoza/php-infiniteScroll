<?php
session_start();

//$_SESSION['favorites'] = [];
if (!isset($_SESSION['favorites']))
{
    $_SESSION['favorites'] = [];
}

function is_favorite($id)
{
    return in_array($id, $_SESSION['favorites']);
}
?>
<!DOCTYPE html> 
<html>
    <head>
        <meta charset="UTF-8">
        <title>Infinite Scrolling</title> 
        <link href="css/main.css" type="text/css" rel="stylesheet">
    </head>
    <body>   
        <div id="blog-posts">
        </div>
        <div id="spinners">
            <img src="icon-spinner.png">
        </div>
        <div id="load_more"  data-page="0" class="load_more">
            Load More
        </div> 
        <script type="text/javascript" src="js/loader.js"></script>
    </body>
</html>
