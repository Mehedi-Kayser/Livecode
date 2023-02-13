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
            <div class="row align-items-center">
                <div class="col">
                    <h2>My Files</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-9" style="margin-top:30px">

                    <table class="table table-borderless " style="background:white;vertical-align:middle">
                        <thead class="table-dark">
                            <tr style="color:grey;">
                                <th></th>
                                <th>Name</th>
                                <th>Language</th>
                                <th>File Size</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                        $sql = "SELECT * FROM user_files WHERE user_id = '$user_id' ORDER BY file_id DESC";
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

                                        $size= filesize("C:/xampp/htdocs/project/livecode/ide/$username/$filename.$filetype");

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
                                        <div class="d-flex">
                                            <a class="btn btn-danger" href="user_delete_file.php?file_id=<?php echo $file_id?>" style="padding:10px 14px;margin-right:10px"><i
                                                    class="fa fa-trash"></i></a>
                                            <a class="btn btn-primary" style="padding:10px 14px"
                                                href="user_download_file.php?file_id=<?php echo $file_id?>"><i
                                                    class="fa fa-download"></i></a>
                                        </div>
                              
                                </td>
                            
                            </tr>
                            <?php
                                        }
                                    }
                                ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-3">
                    <div>
                        <h5 style="margin-bottom:50px">Create New File</h5>
                    </div>
                    <div class="row">
                        <form action="create_file.php" method="POST">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="eventTitle" class="col-form-label">Repo Name</label>
                                    <input type="text" class="form-control" id="eventTitle" name="name"
                                        placeholder="Add Repo Name" required>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top:40px">
                                <div class="form-group">
                                    <label for="eventType">Programming Language</label>
                                    <select id="eventType" class="form-control select2" name="lang" required>
                                        <option value="">Choose Language</option>
                                        <option value="python">Python</option>
                                        <option value="php">PHP</option>
                                        <option value="node.js">NodeJS</option>
                                    </select>
                                </div>
                            </div>
                            <div class=" d-flex justify-content-between" style="margin-top:30px">
                                <div></div>
                                <button type="submit" name="submit" class="btn mb-2 btn-primary">Create
                                    Repo</button>
                            </div>
                        </form>

                    </div>


                </div>
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