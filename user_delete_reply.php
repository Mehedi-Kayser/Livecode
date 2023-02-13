<?php
include_once("./database/config.php");

$reply_id = $_GET['reply_id'];

$query = "DELETE FROM post_reply WHERE reply_id='$reply_id'";
$query_run = mysqli_query($conn, $query);
    if ($query_run) {
        header("Location: user_community.php");
    } else {
        
        header("Location: user_community.php");

    }