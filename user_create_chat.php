<?php
include './database/config.php';
date_default_timezone_set('Asia/Dhaka');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
}

  $first_user_id = $_GET['first_user'];
  $second_user_id = $_GET['second_user'];

  $date=date("d F Y");
  $datetime=date("d F Y h:i A");

  $sql = "SELECT * FROM chat_room WHERE first_user_id='$first_user_id' AND second_user_id='$second_user_id'";
	$result = mysqli_query($conn, $sql);

  if(!$result->num_rows > 0){
    $sql = "INSERT INTO chat_room(first_user_id, second_user_id, create_date) VALUES ('$first_user_id', '$second_user_id', '$date')";
    $result = mysqli_query($conn, $sql);


    if($result){

      $sql2 = "SELECT * from chat_room WHERE first_user_id='$first_user_id' AND second_user_id='$second_user_id'";
      $result2 = mysqli_query($conn, $sql2);
      $row2=mysqli_fetch_assoc($result2);
      $room_id=$row2['room_id'];

      
      $sql3 = "INSERT INTO messages(room_id,first_user_id,second_user_id,message,send_time,sender)
      VALUES ('$room_id', '$first_user_id','$second_user_id','hi', '$datetime', '0')";
      $result3 = mysqli_query($conn, $sql3);
      if($result){
        header("Location: user_messages.php?room_id=$room_id");
      }
    }
  }else{
    $sql2 = "SELECT * from chat_room WHERE first_user_id='$first_user_id' AND second_user_id='$second_user_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2=mysqli_fetch_assoc($result2);
    $room_id=$row2['room_id'];
    
    header("Location: user_messages.php?room_id=$room_id");
  }
?>