<?php
include_once("./database/config.php");

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

$_SESSION['image'] = $img;
$_SESSION['user_id'] = $row['user_id'];
$_SESSION['username'] = $row['username'];

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
        <h2 class="h3 mb-4 page-title">My Chats</h2>

            <div class="row align-items-center justify-content-center">
                <div class="container-fluid">
                    <div class="card-body">
                        <?php
                                #getting course data from the database
                                $sql = "SELECT * from chat_room WHERE first_user_id=$user_id";
                                $result = mysqli_query($conn, $sql);
                                if($result){
                                    while($row=mysqli_fetch_assoc($result)){
                                        $second_user_id = $row['second_user_id'];
                                        $room_id = $row['room_id'];
                                        $date = $row['create_date'];

                                        $sql1 = "SELECT * from users WHERE user_id=$second_user_id";
                                        $result1 = mysqli_query($conn, $sql1);
                                        $row1=mysqli_fetch_assoc($result1);
                                        $second_user_name = $row1['firstname']." ".$row1['lastname'];
                                        $status = $row1['status'];
                                        $second_user_img = $row1['user_img'];

                            ?>
                        <div class="col-12 col-lg-12 col-xl-12 border-right">
                            <a href="user_messages.php?room_id=<?php echo $room_id?>"
                                class="list-group-item list-group-item-action border-0 d-flex justify-content-between">
                                <div class="d-flex align-items-start">
                                    <img src="images/users/<?php echo $second_user_img?>"
                                        class="rounded-circle mr-1" alt="" width="50" style="object-fit: cover;"
                                        height="50">
                                    <div class="flex-grow-1 ml-3"
                                        style="padding-left:30px;font-size:18px;fontweight:700;">
                                        <?php echo $second_user_name?>

                                        <div class="small">Chat Created: <?php echo $date?></div>
                                    </div>
                                </div>

                                <div>
                                    <?php
                                        if($status==1){
                                        ?>
                                    <button class="btn btn-success">Online</button>
                                    <?php
                                        }else{
                                            ?>
                                    <button class="btn btn-danger">Offline</button>
                                    <?php
                                        }
                                        ?>

                                    <?php
                                            ?>
                                </div>
                            </a>
                            <hr>
                        </div>
                        <?php
                                    }
                                }
                            ?>

<?php
                                #getting course data from the database
                                $sql = "SELECT * from chat_room WHERE second_user_id=$user_id";
                                $result = mysqli_query($conn, $sql);
                                if($result){
                                    while($row=mysqli_fetch_assoc($result)){
                                        $first_user_id = $row['first_user_id'];
                                        $room_id = $row['room_id'];
                                        $date = $row['create_date'];

                                        $sql1 = "SELECT * from users WHERE user_id=$first_user_id";
                                        $result1 = mysqli_query($conn, $sql1);
                                        $row1=mysqli_fetch_assoc($result1);
                                        $second_user_name = $row1['firstname']." ".$row1['lastname'];
                                        $status = $row1['status'];
                                        $second_user_img = $row1['user_img'];

                            ?>
                        <div class="col-12 col-lg-12 col-xl-12 border-right">
                            <a href="user_messages.php?room_id=<?php echo $room_id?>"
                                class="list-group-item list-group-item-action border-0 d-flex justify-content-between">
                                <div class="d-flex align-items-start">
                                    <img src="images/users/<?php echo $second_user_img?>"
                                        class="rounded-circle mr-1" alt="" width="50" style="object-fit: cover;"
                                        height="50">
                                    <div class="flex-grow-1 ml-3"
                                        style="padding-left:30px;font-size:18px;fontweight:700;">
                                        <?php echo $second_user_name?>

                                        <div class="small">Chat Created: <?php echo $date?></div>
                                    </div>
                                </div>

                                <div>
                                    <?php
                                        if($status==1){
                                        ?>
                                    <button class="btn btn-success">Online</button>
                                    <?php
                                        }else{
                                            ?>
                                    <button class="btn btn-danger">Offline</button>
                                    <?php
                                        }
                                        ?>

                                    <?php
                                            ?>
                                </div>
                            </a>
                            <hr>
                        </div>
                        <?php
                                    }
                                }
                            ?>
                    </div>

                </div> <!-- .container-fluid -->
            </div>
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