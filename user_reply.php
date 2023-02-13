<?php
include_once("./database/config.php");

date_default_timezone_set('Asia/Dhaka');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
}

$post_id = $_GET['post_id'];
$user_id = $_GET['user_id'];
$date = date("d F Y h:i A");


if (isset($_POST['rep_submit']))
{

    $message = mysqli_real_escape_string($conn,  $_POST['message']);
    $code = mysqli_real_escape_string($conn,  $_POST['reply_code']);

    $date = date("d F Y h:i A");

    $query = "SELECT * FROM post_reply WHERE `message` = '$message' AND user_id='$user_id'";
    $query_run = mysqli_query($conn, $query);

    if (!$query_run->num_rows > 0)
    {

        // Insert record
        $query2 = "INSERT INTO post_reply (post_id, `message`,reply_date,user_id, code)
                                        VALUES ('$post_id', '$message', '$date', '$user_id', '$code')";
        $query_run2 = mysqli_query($conn, $query2);

        if ($query_run2)
        {
            header("Location: user_community.php");
        }
        else
        {
            $cls = "danger";
            $error = mysqli_error($conn);
        }

    }
    else
    {
        $cls = "danger";
        $error = 'You have alredy posted the same Reply';
    }

}

