<?php
include_once("./database/config.php");

$post_id = $_GET['post_id'];

$query = "DELETE FROM posts WHERE post_id='$post_id'";
$query_run = mysqli_query($conn, $query);
    if ($query_run) {
        header("Location: user_community.php");
    } else {
        
        header("Location: user_community.php");

    }