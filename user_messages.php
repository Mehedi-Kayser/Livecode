<?php
include_once("./database/config.php");
date_default_timezone_set('Asia/Dhaka');
session_start();
$username = $_SESSION['username'];

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php");
}

$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$img=$row['user_img'];
$user_id=$row['user_id'];

$image = $row['user_img'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$about_me=$row['about_me'];
$gender=$row['gender'];
$birthday=$row['birthday'];
$contact=$row['contact'];
$email=$row['email'];
$address=$row['address'];
$city=$row['city'];
$zip=$row['zip'];

$_SESSION['image'] = $img;
$_SESSION['user_id'] = $row['user_id'];
$_SESSION['username'] = $row['username'];

$room_id= $_GET['room_id'];

#room info
$sql1 = "SELECT * from messages WHERE room_id=$room_id";
$result1 = mysqli_query($conn, $sql1);
$row1=mysqli_fetch_assoc($result1);

$first_user_id=$row1['first_user_id'];
$second_user_id=$row1['second_user_id'];
$message=$row1['message'];
$send_time=$row1['send_time'];

if($first_user_id == $user_id){
    $main=$first_user_id;
    $sec = $second_user_id;
}else{
    $sec=$first_user_id;
    $main = $second_user_id;
}



if(isset($_POST['submit'])){

    $message = $_POST['message'];
    $date = date("d F Y h:i A");


        // Insert record

        $query2 = "INSERT INTO messages(room_id, first_user_id, second_user_id, message, send_time, sender)
        VALUES ('$room_id', '$main','$sec','$message', '$date', '$main')";
        $query_run2 = mysqli_query($conn, $query2);
            
        if ($query_run2) {
            $cls="success";
            $error = "Message Successfully Added.";
        } 
        else {
            $cls="danger";
            $error = mysqli_error($conn);
        }
   
}
?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">

    <title>Livecode - Online Code Compiler</title>

    <!-- # Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- # CSS Plugins -->
    <link rel="stylesheet" href="plugins/slick/slick.css">
    <link rel="stylesheet" href="plugins/font-awesome/fontawesome.min.css">
    <link rel="stylesheet" href="plugins/font-awesome/brands.css">
    <link rel="stylesheet" href="plugins/font-awesome/solid.css">
</head>
<!-- # Main Style Sheet -->
<link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- navigation -->
    <?php include_once("./templates/user_header.php");?>
    <!-- /navigation -->

    <section class="banner bg-tertiary position-relative overflow-hidden" id="home">
        <div class="container">
            <div class="col-12 col-lg-12 col-xl-12" style="height:57vh; overflow-y: scroll;">

                <div class="position-relative">
                    <div class="chat-messages p-3" style="display: flex; flex-direction: column-reverse;">
                        <?php
                        #getting message data from the database
                        $sql = "SELECT * from messages WHERE first_user_id=$first_user_id AND second_user_id =$second_user_id OR first_user_id=$second_user_id AND second_user_id =$first_user_id order by message_id ";
                        $result = mysqli_query($conn, $sql);
                        if($result){
                            while($row=mysqli_fetch_assoc($result)){
                                $message = $row['message'];
                                $send_time = $row['send_time'];
                                $sender = $row['sender'];

                                if($sender == $user_id){

                            ?>
                        <div class="d-flex justify-content-end mb-4" style="padding-top:10px;">
                            <div class="bg-light rounded py-2 px-3 mr-3" style="margin-right:20px;">
                                <div class="mb-1" style="font-weight:600;">You</div>
                                <span style="font-size:16px"><?php echo $message?></span>
                                <div class="text-muted small text-nowrap mt-2" style="font-size:11px">
                                    <?php echo $send_time ?></div>

                            </div>
                            <div>
                                <img src="images/users/<?php echo $image?>" class="rounded-circle mr-1"
                                    style="object-fit:cover" alt="" width="64" height="64">
                            </div>

                        </div>
                        <?php
                                }else{
                                    #ngo info
                                    $sql2 = "SELECT * from users WHERE user_id=$sec";
                                    $result2 = mysqli_query($conn, $sql2);
                                    $row2=mysqli_fetch_assoc($result2);

                                    $sec_name=$row2['firstname']." ".$row2['lastname'];
                                    $sec_img=$row2['user_img'];
                                    $sec_status=$row2['status'];

                    ?>
                        <div class="d-flex pb-4" style="padding-top:10px;">
                            <div style="margin-right:20px;">
                                <img src="images/users/<?php echo $sec_img?>" class="rounded-circle mr-1" alt=""
                                    width="64" height="64" style="object-fit:cover">
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                <div class="font-weight-bold mb-1" style="font-weight:600;">
                                    <?php echo $sec_name?></div>
                                <?php echo $message?>
                                <div class="text-muted small text-nowrap mt-2"><?php echo $send_time ?></div>

                            </div>
                        </div>

                        <?php
                                }
                            }
                        }
                    ?>

                    </div>
                </div>
            </div>

            <form action="" method="POST">
                <div class="flex-grow-0 py-3 px-4 border-top">
                    <div class="input-group">
                        <input type="text" name="message" class="form-control" placeholder="Type your message" required>
                        <button class="btn btn-primary" type="submit" name="submit">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php include_once("./templates/footer.php");?>

    <!-- # JS Plugins -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/bootstrap.min.js"></script>
    <script src="plugins/slick/slick.min.js"></script>
    <script src="plugins/scrollmenu/scrollmenu.min.js"></script>

    <!-- Main Script -->
    <script src="js/script.js"></script>

</body>

</html>