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

$user_id = $_SESSION['user_id'];

if(isset($_POST['submit'])){

    $title = mysqli_real_escape_string($conn,  $_POST['title']);
    $code = mysqli_real_escape_string($conn,  $_POST['code']);
    $description = mysqli_real_escape_string($conn,  $_POST['description']);
    $date = date("d F Y h:i A");

    $query = "SELECT * FROM posts WHERE topic = '$title' AND `user_id` = '$user_id'";
    $query_run = mysqli_query($conn, $query);

    if (!$query_run->num_rows > 0) {

        // Insert record

        $query2 = "INSERT INTO posts(topic,description,post_date,code, user_id)
        VALUES ('$title', '$description', '$date', '$code','$user_id')";
        $query_run2 = mysqli_query($conn, $query2);
            
        if ($query_run2) {
            $cls="success";
            $error = "Post Successfully Added.";
        } 
        else {
            $cls="danger";
            $error = mysqli_error($conn);
        }

    }else{
        $cls="danger";
        $error = 'Post Already Exists.';
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

    <section class="bg-tertiary position-relative overflow-hidden" id="home" style="padding-top:30px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <form method="POST" action="">
                        <div class="alert alert-<?php echo $cls;?>">
                            <?php 
                                                                if (isset($_POST['submit'])){
                                                                    echo $error;
                                                                }
                                                            ?>
                        </div>
                        <div class="row text-dark">

                            <div class="col-md-12" style="">
                                <label class="control-label" style="padding-bottom:10px;">
                                    Question Title</label><br>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="Write A Title">

                            </div>
                            <div class="col-md-12" style="padding-top:15px;">
                                <label class="control-label" style="padding-bottom:10px;">
                                    Question Description</label><br>
                                <textarea name="description" class="form-control" id="" cols="56" rows="5"
                                    placeholder="Ask A Question"></textarea>
                            </div>
                            <div class="col-md-12" style="padding-top:15px;">
                                <label class="control-label" style="padding-bottom:10px;">
                                    Code Sample</label><br>
                                <textarea name="code" class="form-control" id="" cols="56" rows="5"
                                    placeholder="Code Sample (if any)"></textarea>
                            </div>

                        </div>
                        <div class="d-flex justify-content-between">
                            <p></p>
                            <button type="submit" name="submit" class="btn btn-success"
                                style="padding:auto 90px;margin-top:20px">Ask a Question</button>
                        </div>
                    </form>

                    <!-- Post /////-->
                    <div class="card gedf-card" style="overflow-y:scroll;height:250vh; margin-top:50px">
                        <?php 
                            $sql = "SELECT * FROM posts ORDER BY post_id DESC";
                            $result = mysqli_query($conn, $sql);
                            if($result){
                                while($row=mysqli_fetch_assoc($result)){
                                    $id=$row['post_id'];
                                    $post_user_id=$row['user_id'];

                                    $topic=$row['topic'];
                                    $description=$row['description'];
                                    $code=$row['code'];
                                    $post_date=$row['post_date'];

                                    $sql1 = "SELECT * FROM users where user_id =$post_user_id";
                                    $result1 = mysqli_query($conn, $sql1);
                                    $row1=mysqli_fetch_assoc($result1);

                                    $username=$row1['username'];
                                    $firstname=$row1['firstname'];
                                    $lastname=$row1['lastname'];
                                    $user_img=$row1['user_img'];
                                    
                        ?>
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-2" style="padding-right:20px;">
                                        <img class="rounded-circle" width="45"
                                            src="./images/users/<?php echo $user_img?>" alt="">
                                    </div>
                                    <div class="">
                                        <div class="h5"><a href="user_public_profile.php?user_id=<?php echo $user_id?>">@<?php echo $username?></a></div>
                                    </div>
                                </div>
                                <div>
                                <?php
                                    if($user_id==$post_user_id){
                                    ?>
                                    <a href="user_delete_post.php?post_id=<?php echo $id?>" class="btn btn-danger" style="padding:12px 18px"><i
                                            class="fa fa-trash"></i></a>
                                    <?php
                                    }else{}
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding-left:40px;">
                            <div class="row">
                                <div class="col-12" style="padding:20px 40px 40px 0">
                                    <div class="text-muted h7 mb-2"> <i
                                            class="fa fa-clock-o"></i><?php echo $post_date?></div>
                                    <h4 class="card-title" style="font-size:25px;color:#222;font-weight:700;">
                                        <?php echo $topic?></h5>

                                        <p class="card-text">
                                            <?php echo $description?>
                                        </p>
                                        <pre style="font-family:'roboto'"><?php echo $code?></pre>
                                </div>
                            </div>

                            <!--reply-->

                            <div class="flex-grow-0 py-3 px-4 border-top" style="padding:0;">
                                <?php 


                                $sql1 = "SELECT * FROM post_reply where post_id=$id ORDER BY reply_id DESC";
                                $result1 = mysqli_query($conn, $sql1);
                                if($result1){
                                    while($row=mysqli_fetch_assoc($result1)){
                                        $reply_id=$row['reply_id'];
                                        $ruser_id=$row['user_id'];

                                        $message=$row['message'];
                                        $rep_code=$row['code'];
                                        $reply_date=$row['reply_date'];

                                        $sql1 = "SELECT * FROM users where user_id =$ruser_id";
                                        $result1 = mysqli_query($conn, $sql1);
                                        $row1=mysqli_fetch_assoc($result1);
    
                                        $username1=$row1['username'];
                                        $user_img1=$row1['user_img'];
                                        
                                ?>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-between align-items-center ">
                                        <div class="mr-2">
                                            <img class="rounded-circle" width="50"
                                                src="./images/users/<?php echo $user_img1?>" alt="">
                                        </div>
                                        <div class="ml-2" style="margin-left:20px;">
                                            <div class="h5 m-0"><a href="user_public_profile.php?user_id=<?php echo $ruser_id?>">@<?php echo $username1?></a></div>
                                        </div>
                                    </div>
                                    <div>
                                    <?php
                                    if($user_id==$ruser_id){
                                    ?>
                                    <a href="user_delete_reply.php?reply_id=<?php echo $reply_id?>" class="btn btn-danger" style="padding:12px 18px"><i
                                            class="fa fa-trash"></i></a>
                                    <?php
                                    }else{}
                                    ?>
                               
                                    </div>
                                </div>
                                <div class="card-body " style="margin-top:20px;">
                                    <div class="row">
                                        <div class="col-12" style="padding:0">
                                            <div class="text-muted h7 mb-2"> <i
                                                    class="fa fa-clock-o"></i><?php echo $reply_date?>
                                            </div>

                                            <p class="card-text">
                                                <?php echo $message?>
                                            </p>
                                        <pre style="font-family:'roboto'"><?php echo $rep_code?></pre>
                                        </div>
                                    </div>
                                </div>

                                <?php 
                                    }
                                }
                                ?>
                                <div class="card-footer" style="padding:30px;">
                                    <form action="user_reply.php?post_id=<?php echo $id?>&user_id=<?php echo $user_id?>"
                                        method="POST">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group">

                                                    <textarea name="message" class="form-control"
                                                        placeholder="Type Your Reply" rows="2"></textarea>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group">

                                                    <textarea name="reply_code" class="form-control"
                                                        placeholder="Enter Code (if Any)" rows="2"></textarea>

                                                </div>
                                            </div>
                                        </div>


                                        <button class="btn btn-success" style="margin-left:10px;margin-top:20px"
                                            type="submit" name="rep_submit">Post</button>
                                    </form>
                                </div>
                            </div>



                        </div>
                        <?php 
                                    }
                                }
                            ?>
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