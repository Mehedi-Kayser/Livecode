<?php
include_once("./database/config.php");

session_start();
$username = $_SESSION['adminname'];

if (!isset($_SESSION['adminname'])) {
    header("Location: admin_login.php");
}

$sql = "SELECT * FROM `admin` WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$img=$row['admin_img'];

$_SESSION['image'] = $img;
$_SESSION['admin_id'] = $row['admin_id'];
$_SESSION['username'] = $row['username'];


$admin_id = $_SESSION['admin_id'];

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
    <?php include_once("./templates/admin_header.php");?>
    <!-- /navigation -->

    <section class="banner bg-tertiary position-relative overflow-hidden" id="home">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="container-fluid">
                    <div class="float-right">

                        <a class="small btn btn-primary" style="padding:15px 25px;margin-left:20px;margin-bottom:40px" href="admin_users_add.php">Add
                            User</a>
                    </div>
                    <table class="table text-dark">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Birthday</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                                            $sql1 = "SELECT * FROM users";
                                                            $result1 = mysqli_query($conn, $sql1);
                                                            if($result1){
                                                                while($row1=mysqli_fetch_assoc($result1)){

                                                                $firstname=$row1['firstname'];
                                                                $lastname=$row1['lastname'];
                                                                $birthday=$row1['birthday'];
                                                                $gender=$row1['gender'];
                                                                $contact=$row1['contact'];
                                                                $email=$row1['email'];
                                                                $address=$row1['address'];
                                                                $city=$row1['city'];
                                                                $zip=$row1['zip'];
                                                                $image=$row1['user_img'];
                                                                $user_id=$row1['user_id'];

                                                        ?>
                            <tr>
                                <td><?php echo $user_id ?></td>
                                <td><img src="images/users/<?php echo $image ?>" style="width:50px;border-radius: 20%;"
                                        alt="prouser"></td>
                                <td><?php echo $firstname." ".$lastname ?></td>
                                <td><?php echo $gender ?></td>
                                <td><?php echo $birthday ?></td>
                                <td><?php echo $contact ?></td>
                                <td><?php echo $email ?></td>
                                <td><?php echo $address." ".$city."-".$zip ?></td>

                                <td>
                                    <a class="btn btn-danger deletebtn" href="admin_user_delete.php?user_id=<?php echo $user_id?>"><i class="fa fa-trash"></i></a>


                                </td>
                                                                </tr>

                            <?php
                                                                }
                                                            }
                                                        ?>

                        </tbody>
                    </table>

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