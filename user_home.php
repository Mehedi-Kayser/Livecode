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

$_SESSION['image'] = $img;
$_SESSION['user_id'] = $row['user_id'];
$_SESSION['username'] = $row['username'];

$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$img=$row['user_img'];

$_SESSION['image'] = $img;
$_SESSION['user_id'] = $row['user_id'];
$_SESSION['username'] = $row['username'];

$user_id = $_SESSION['user_id'];

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
            <div class="row align-items-center justify-content-center">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="file-container">
                                <div class="file-panel ">
                                    <div class="row my-4">
                                        <div class="col-md-4">
                                            <div class="card shadow mb-6">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <p class="mb-3" style="font-size:16px;">My Files</p>
                                                            <?php
                                                            $sql = "SELECT * from user_files where user_id=$user_id";
                                                            $result = mysqli_query($conn, $sql);
                                                            $count = $result->num_rows;
                                                        ?>
                                                            <h3 class="card-title mb-0"><?php echo $count?></h3>

                                                        </div>
                                                        <div class="col-4 text-right">
                                                            <span class="fa fa-users" style="font-size:30px;"></span>
                                                        </div>
                                                    </div> <!-- /. row -->
                                                </div> <!-- /. card-body -->
                                            </div> <!-- /. card -->
                                        </div> <!-- /. col -->
                                        <div class="col-md-4">
                                            <div class="card shadow mb-6">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <p class="mb-3" style="font-size:16px;">Questions Asked</p>
                                                            <?php
                                                            $sql = "SELECT * from posts where user_id=$user_id";
                                                            $result = mysqli_query($conn, $sql);
                                                            $count = $result->num_rows;
                                                        ?>
                                                            <h3 class="card-title mb-0"><?php echo $count?></h3>

                                                        </div>
                                                        <div class="col-4 text-right">
                                                            <span class="fa fa-user-graduate"
                                                                style="font-size:30px;"></span>
                                                        </div>
                                                    </div> <!-- /. row -->
                                                </div> <!-- /. card-body -->
                                            </div> <!-- /. card -->
                                        </div> <!-- /. col -->
                                        <div class="col-md-4">
                                            <div class="card shadow mb-6">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <p class="mb-3" style="font-size:16px;">Conversations</p>
                                                            <?php
                                                            $sql = "SELECT * from chat_room where first_user_id=$user_id or second_user_id=$user_id";
                                                            $result = mysqli_query($conn, $sql);
                                                            $count = $result->num_rows;
                                                        ?>
                                                            <h3 class="card-title mb-0"><?php echo $count?></h3>

                                                        </div>
                                                        <div class="col-4 text-right">
                                                            <span class="fa fa-school" style="font-size:30px;"></span>
                                                        </div>
                                                    </div> <!-- /. row -->
                                                </div> <!-- /. card-body -->
                                            </div> <!-- /. card -->
                                        </div> <!-- /. col -->
                                    </div> <!-- end section -->
                                    <div class="row align-items-center mb-4" style="margin-top:70px">
                                        <div class="col">
                                            <h3>Recent Files</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table>
                                            <tbody class="d-flex">
                                                <?php 
                                                $sql = "SELECT * FROM user_files WHERE user_id = '$user_id' ORDER BY file_id DESC LIMIT 12";
                                                $result = mysqli_query($conn, $sql);
                                                if($result){
                                                    while($row=mysqli_fetch_assoc($result)){
                                                    
                                                        $file_id =$row['file_id'];
                                                        $filename =$row['filename'];
                                                        $filetype =$row['filetype'];
                                                        $created =$row['created'];
 

                                                        $icon = "";
                                                        $com_lang = "";
                                                        
                                                        if($filetype=="c"){
                                                            $icon = "c-lang.png";
                                                        }
                                                        if($filetype=="cpp"){
                                                            $icon = "cpp.png";
                                                        }
                                                        if($filetype=="python"){
                                                            $icon = "python.png";
                                                        }
                                                        if($filetype=="php"){
                                                            $icon = "php.png";
                                                        }
                                                        if($filetype=="node.js"){
                                                            $icon = "node.png";
                                                        }

                                            ?>

                                                <tr>
                                                    <td style="display:none;">

                                                        <p><?php echo $file_id?></p>

                                                    </td>
                                                    <td class="col-md-6 col-lg-4">
                                                        <div class="card shadow mb-4">
                                                            <div class="card-body file-list">
                                                                <div class="d-flex align-items-center">

                                                                    <div class="circle circle-md ">
                                                                        <a href=""> <img
                                                                                src="images/icons/<?php echo $icon?>"
                                                                                alt=""
                                                                                style="width:44px;height:44px; object-fit:cover"></a>
                                                                    </div>
                                                                    <div class="flex-fill ml-4 fname">
                                                                        <a
                                                                            href="compiler.php?file_id=<?php echo $file_id?>"><strong><?php echo $filename?>.<?php echo $filetype?></strong></a><br />
                                                                        <span
                                                                            class="badge badge-light text-muted">Created
                                                                            Date:
                                                                            <?php echo $created ?></span>
                                                                    </div>
                                                                    <div class="file-action">
                                                                        <button type="button"
                                                                            class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-haspopup="true" aria-expanded="false">
                                                                            <span
                                                                                class="text-muted sr-only">Action</span>
                                                                        </button>
                                                                        <div class="dropdown-menu m-2">
                                                                            <a class="dropdown-item"
                                                                                href="../compiler.php?file_id=<?php echo $file_id?>"><i
                                                                                    class="fe fe-edit-3 fe-12 mr-4"></i>Edit
                                                                                Repo</a>
                                                                            <a class="dropdown-item deletebtn" href="#"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#deleteModal"><i
                                                                                    class="fe fe-delete fe-12 mr-4"></i>Delete</a>
                                                                            <a class="dropdown-item"
                                                                                href="../download-repo.php?file_id=<?php echo $file_id?>"><i
                                                                                    class="fe fe-download fe-12 mr-4"></i>Download</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- .card-body -->
                                                        </div> <!-- .col -->
                                                    </td>
                                                </tr>
                                                <?php
                                                    }
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- .row -->

                                </div> <!-- .file-panel -->

                            </div> <!-- .file-container -->
                        </div> <!-- .col -->
                    </div> <!-- .row -->

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