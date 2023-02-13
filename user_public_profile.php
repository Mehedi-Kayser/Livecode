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

$profile_user_id =$_GET['user_id'];

$sql1 = "SELECT * FROM users WHERE user_id='$profile_user_id'";
$result1 = mysqli_query($conn, $sql1);
$row1=mysqli_fetch_assoc($result1);
$img=$row1['user_img'];

$username1 = $row1['username'];
$image1 = $row1['user_img'];
$firstname1=$row1['firstname'];
$lastname1=$row1['lastname'];
$about_me1=$row1['about_me'];
$gender1=$row1['gender'];
$birthday1=$row1['birthday'];
$contact1=$row1['contact'];
$email1=$row1['email'];
$address1=$row1['address'];
$city1=$row1['city'];
$zip1=$row1['zip'];


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
    <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-10 col-xl-8">
            <div class="my-4">
              <form action="" method="POST" enctype='multipart/form-data'>
                <div class="row mt-5 align-items-center">
                  <div class="col-md-3 text-center mb-5">
                    <div class="avatar avatar-xl">
                      <img src="images/users/<?php echo $image1?>" alt="..." class="avatar-img rounded-circle">
                    </div>
                  </div>
                  <div class="col">
                    <div class="row align-items-center" style="padding-left:30px;">
                      <div class="col-md-7">
                        <h3 class="mb-1"><?php echo $firstname1." ".$lastname1?></h3>
                        <p class="small mb-3"><span class="badge badge-dark"><?php echo $city1;?>, Bangladesh</span></p>
                      </div>
                    </div>
                    <div class="row mb-4" style="padding-left:30px;">
                      <div class="col-md-7">
                        <p class="text-muted"><?php echo $about_me1;?></p>
                      </div>
                      <div class="col">
                        <p class="small mb-0 text-muted"><?php echo $address1?></p>
                        <p class="small mb-0 text-muted"><?php echo $city1?> - <?php echo $zip1;?></p>
                        <p class="small mb-0 text-muted"><?php echo $contact1?></p>
                      </div>
                    </div>
                    <?php
                    if(!($user_id==$profile_user_id)){
                    ?>
                    <a href="user_create_chat.php?first_user=<?php echo $user_id ?>&second_user=<?php echo $profile_user_id ?>" class="btn btn-success text-end">Send Message</a>
                    <?php
                    }else{}
                    ?>
                  </div>

                </div>
              </form>
              <hr class="my-4">
              <table class="table table-borderless " style="background:white;vertical-align:middle">
                        <thead class="table-dark">
                            <tr style="color:grey;">
                                <th></th>
                                <th>Name</th>
                                <th>Language</th>
                                <th>File Size</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                        $sql = "SELECT * FROM user_files WHERE user_id = '$profile_user_id' ORDER BY file_id DESC";
                                        $result = mysqli_query($conn, $sql);
                                        if($result){
                                            while($row=mysqli_fetch_assoc($result)){
                                            
                                                $file_id =$row['file_id'];
                                                $filename =$row['filename'];
                                                $filetype =$row['filetype'];
                                                $created =$row['created'];
                                                $description =$row['description'];
                                            

                                                $icon = "";
                                                $com_lang = "";
                                                
                                                if($filetype=="python"){
                                                    $icon = "python.png";
                                                    $lang="Python";

                                                }
                                                elseif($filetype=="php"){
                                                    $icon = "php.png";
                                                    $lang="PHP";

                                                }
                                                elseif($filetype=="node.js"){
                                                    $icon = "node.png";
                                                    $lang="Javascript";

                                                }
                                    ?>
                            <tr>
                                <td class="text-center" style="display:none;">
                                    <div class="">
                                        <?php echo $file_id?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="">
                                        <img src="images/icons/<?php echo $icon?>" alt=""
                                            style="width:44px;height:44px; object-fit:cover">
                                    </div>
                                </td>
                                <th scope="row"><a
                                        href="compiler.php?file_id=<?php echo $file_id?>"><strong><?php echo $filename?>.<?php echo $filetype?></strong></a><br />

                                    <span class="badge badge-light text-muted mr-2"><?php echo $created ?></span>

                                </th>
                                <td class="text-muted"><?php echo $lang ?></td>
                                <?php

                                        $size= filesize("C:/xampp/htdocs/project/livecode/ide/$username1/$filename.$filetype");

                                        if($size < 1024) {
                                    ?>
                                <td class="text-muted"><?php echo $size. " Bytes"?></td>
                                <?php
                                        }else if($size < 1024000) {
                                    ?>
                                <td class="text-muted"><?php echo round(($size / 1024 ), 1)." KB"?></td>
                                <?php
                                        }else {
                                    ?>
                                <td class="text-muted"><?php echo round(($size / 1024000), 1) . "MB"?></td>
                                <?php
                                        }
                                    ?>
                                <td>
                                    <div class="file-action">
                                        <button type="button"
                                            class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted sr-only">Action</span>
                                        </button>
                                        <div class="dropdown-menu m-2">

                                            <a class="dropdown-item"
                                                href="../compiler.php?file_id=<?php echo $file_id?>"><i
                                                    class="fe fe-edit-3 fe-12 mr-4"></i>Edit Repo</a>
                                            <a class="dropdown-item deletebtn" href="#" data-toggle="modal"
                                                data-target="#deleteModal"><i
                                                    class="fe fe-delete fe-12 mr-4"></i>Delete</a>
                                            <a class="dropdown-item"
                                                href="../download-repo.php?file_id=<?php echo $file_id?>"><i
                                                    class="fe fe-download fe-12 mr-4"></i>Download</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                        }
                                    }
                                ?>
                        </tbody>
                    </table>
            </div> <!-- /.card-body -->
          </div> <!-- /.col-12 -->
        </div> <!-- .row -->
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